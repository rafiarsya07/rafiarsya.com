/* ============================================================
   RafiChart — dependency-free interactive SVG charts
   Line: metric/range toggles, animated zoom + Y-rescale,
         hover/touch crosshair + tooltip (mobile-friendly).
   Bar : animated, sortable, hover/touch tooltip.
   API : RafiChart.line(hostEl, cfg) / RafiChart.bar(hostEl, cfg)
   ============================================================ */
(function(){
  const NS='http://www.w3.org/2000/svg';
  const $=(t,a,p)=>{const e=document.createElementNS(NS,t);if(a)for(const k in a)e.setAttribute(k,a[k]);if(p)p.appendChild(e);return e;};
  const H=(t,a,p)=>{const e=document.createElement(t);if(a)for(const k in a){if(k==='class')e.className=a[k];else if(k==='html')e.innerHTML=a[k];else e.setAttribute(k,a[k]);}if(p)p.appendChild(e);return e;};
  const ease=t=>t<.5?4*t*t*t:1-Math.pow(-2*t+2,3)/2;
  const lerp=(a,b,t)=>a+(b-a)*t;
  const clamp=(v,a,b)=>v<a?a:v>b?b:v;

  /* ---------------- LINE CHART ---------------- */
  function line(host, cfg){
    const VBW=760,VBH=380,PL=52,PR=18,PT=18,PB=42;
    const PW=VBW-PL-PR, PH=VBH-PT-PB;
    let mi=0, ri=0;
    const hidden=Object.create(null);
    let anim=null, entered=false, lastIdx=null;

    const head=H('div',{class:'rafi-head'},host);
    const ctr=H('div',{class:'rafi-ctrls'},head);
    const segM=H('div',{class:'rafi-seg'},ctr);
    const segR=H('div',{class:'rafi-seg'},ctr);
    const wrap=H('div',{class:'rafi-svg-wrap'},host);
    const svg=$('svg',{class:'rafi-svg',viewBox:'0 0 '+VBW+' '+VBH,preserveAspectRatio:'xMidYMid meet'},wrap);
    const tip=H('div',{class:'rafi-tip'},wrap);
    const leg=H('div',{class:'rafi-legend'},host);
    if(cfg.caption){ const c=H('div',{class:'rafi-cap'},host); c.textContent=cfg.caption; }

    const defs=$('defs',null,svg);
    const cp=$('clipPath',{id:host.id+'-clip'},defs); $('rect',{x:PL,y:PT-4,width:PW,height:PH+8},cp);
    const grad=$('linearGradient',{id:host.id+'-grad',x1:0,y1:0,x2:0,y2:1},defs);
    const gs0=$('stop',{offset:'0%'},grad), gs1=$('stop',{offset:'100%'},grad); gs1.setAttribute('stop-opacity','0');
    const gGrid=$('g',{class:'rafi-grid'},svg);
    const gAxis=$('g',{class:'rafi-axis'},svg);
    const gXax=$('g',{class:'rafi-axis'},svg);
    const area=$('path',{fill:'url(#'+host.id+'-grad)','clip-path':'url(#'+host.id+'-clip)',opacity:'0'},svg);
    const gLines=$('g',{'clip-path':'url(#'+host.id+'-clip)'},svg);
    const gHover=$('g',{opacity:'0'},svg);
    const cross=$('line',{stroke:'var(--text-3,#909090)','stroke-width':'1','stroke-dasharray':'3 3',y1:PT,y2:PT+PH},gHover);
    const paths={}, dots={};
    for(const k in cfg.series){
      paths[k]=$('path',{fill:'none','stroke-width':'2.4','stroke-linejoin':'round','stroke-linecap':'round',stroke:cfg.series[k].color,opacity:'0'},gLines);
      dots[k]=$('circle',{r:'4.5',fill:'#fff','stroke-width':'2.5',stroke:cfg.series[k].color,opacity:'0'},gHover);
    }

    const metric=()=>cfg.metrics[mi];
    const range=()=>cfg.ranges[ri].span;
    const keysAll=()=>metric().keys;
    const keysOn=()=>metric().keys.filter(k=>!hidden[k]);

    function extent(){
      const [i0,i1]=range(); const ks=keysOn().length?keysOn():keysAll();
      let mn=Infinity,mx=-Infinity;
      for(const k of ks){const d=cfg.series[k].data;for(let i=Math.floor(i0);i<=Math.ceil(i1);i++){if(i<0||i>=d.length)continue;if(d[i]<mn)mn=d[i];if(d[i]>mx)mx=d[i];}}
      if(mn===Infinity){mn=0;mx=1;} const pad=(mx-mn||1)*0.12; mn-=pad; mx+=pad;
      if(metric().floor0 && mn<0) mn=0;
      if(metric().cap!=null && mx>metric().cap) mx=metric().cap;
      return [i0,i1,mn,mx];
    }
    let cur=null;
    const target=()=>{const [i0,i1,mn,mx]=extent();return {i0,i1,mn,mx};};
    const xAt=(i,sc)=>PL+((i-sc.i0)/((sc.i1-sc.i0)||1))*PW;
    const yAt=(v,sc)=>PT+(1-(v-sc.mn)/((sc.mx-sc.mn)||1))*PH;
    function dFor(k,sc){const d=cfg.series[k].data;let s='';for(let i=0;i<d.length;i++)s+=(i?'L':'M')+xAt(i,sc).toFixed(2)+' '+yAt(d[i],sc).toFixed(2);return s;}
    function areaFor(k,sc){const d=cfg.series[k].data;let s='M'+xAt(0,sc).toFixed(2)+' '+(PT+PH);for(let i=0;i<d.length;i++)s+='L'+xAt(i,sc).toFixed(2)+' '+yAt(d[i],sc).toFixed(2);s+='L'+xAt(d.length-1,sc).toFixed(2)+' '+(PT+PH)+'Z';return s;}

    function grid(sc){
      gGrid.textContent=''; gAxis.textContent='';
      const N=5;
      for(let t=0;t<N;t++){
        const v=lerp(sc.mn,sc.mx,t/(N-1)); const y=yAt(v,sc);
        $('line',{x1:PL,x2:PL+PW,y1:y.toFixed(1),y2:y.toFixed(1)},gGrid);
        const tx=$('text',{x:PL-8,y:(y+3).toFixed(1),'text-anchor':'end'},gAxis); tx.textContent=metric().fmt(v);
      }
    }
    function xaxis(sc){
      gXax.textContent='';
      const [i0,i1]=[sc.i0,sc.i1]; const span=i1-i0; const ticks=span<=10?span+1:6;
      for(let t=0;t<ticks;t++){
        const idx=Math.round(lerp(i0,i1,t/(ticks-1))); const x=xAt(idx,sc);
        const tx=$('text',{x:x.toFixed(1),y:VBH-16,'text-anchor':'middle'},gXax); tx.textContent=cfg.labels[idx];
      }
      const lab=$('text',{x:(PL+PW/2).toFixed(1),y:VBH-2,'text-anchor':'middle',fill:'var(--text-3,#909090)'},gXax); lab.textContent=cfg.xTitle||'';
    }
    function applyAll(sc){
      grid(sc); xaxis(sc);
      const on=keysOn(); const prim=on[0]||keysAll()[0];
      gs0.setAttribute('stop-color',cfg.series[prim].color); gs0.setAttribute('stop-opacity','0.16');
      gs1.setAttribute('stop-color',cfg.series[prim].color);
      area.setAttribute('d',areaFor(prim,sc));
      for(const k in paths){
        const onk=metric().keys.indexOf(k)>=0 && !hidden[k];
        paths[k].setAttribute('d',dFor(k,sc));
        paths[k].setAttribute('opacity', onk?'1':'0');
      }
      area.setAttribute('opacity', on.length?'0.9':'0');
      if(lastIdx!=null) moveHover(lastIdx,sc);
    }
    function tweenTo(tg,dur){
      if(anim)cancelAnimationFrame(anim);
      const from={...cur}, t0=performance.now();
      (function step(now){
        const p=clamp((now-t0)/dur,0,1), e=ease(p);
        cur={i0:lerp(from.i0,tg.i0,e),i1:lerp(from.i1,tg.i1,e),mn:lerp(from.mn,tg.mn,e),mx:lerp(from.mx,tg.mx,e)};
        applyAll(cur);
        if(p<1)anim=requestAnimationFrame(step);
      })(t0);
    }
    function drawIn(keys,dur){
      keys.forEach(k=>{const L=paths[k].getTotalLength();paths[k].style.transition='none';paths[k].setAttribute('stroke-dasharray',L);paths[k].setAttribute('stroke-dashoffset',L);
        requestAnimationFrame(()=>{paths[k].style.transition='stroke-dashoffset '+dur+'ms cubic-bezier(.4,0,.2,1)';paths[k].setAttribute('stroke-dashoffset',0);
          setTimeout(()=>{paths[k].style.transition='';paths[k].removeAttribute('stroke-dasharray');paths[k].removeAttribute('stroke-dashoffset');},dur+40);});});
    }
    function setMetric(n){ if(n===mi)return; mi=n; renderSeg(); cur=target(); applyAll(cur); buildLegend(); drawIn(keysOn(),600); }
    function setRange(n){ if(n===ri)return; ri=n; renderSegR(); tweenTo(target(),480); }
    function toggleKey(k){ hidden[k]=!hidden[k]; buildLegend(); tweenTo(target(),420); }

    let segMbtns=[], segRbtns=[];
    const renderSeg=()=>segMbtns.forEach((b,i)=>b.classList.toggle('on',i===mi));
    const renderSegR=()=>segRbtns.forEach((b,i)=>b.classList.toggle('on',i===ri));
    cfg.metrics.forEach((m,i)=>{const b=H('button',null,segM);b.textContent=m.name;b.onclick=()=>setMetric(i);segMbtns.push(b);});
    cfg.ranges.forEach((r,i)=>{const b=H('button',null,segR);b.textContent=r.name;b.onclick=()=>setRange(i);segRbtns.push(b);});
    if(cfg.metrics.length<2) segM.style.display='none';
    if(cfg.ranges.length<2) segR.style.display='none';
    renderSeg(); renderSegR();

    function buildLegend(){
      leg.textContent='';
      keysAll().forEach(k=>{
        const it=H('div',{class:'rafi-leg'+(hidden[k]?' off':'')},leg);
        const sw=H('span',{class:'sw'},it); sw.style.background=cfg.series[k].color;
        const tx=H('span',null,it); tx.textContent=cfg.series[k].name;
        it.onclick=()=>toggleKey(k);
      });
    }
    buildLegend();

    function dataXFromClient(cx){const r=svg.getBoundingClientRect();const vx=(cx-r.left)/r.width*VBW;return cur.i0+((vx-PL)/PW)*(cur.i1-cur.i0);}
    function moveHover(idx,sc){
      const x=xAt(idx,sc);
      cross.setAttribute('x1',x); cross.setAttribute('x2',x);
      const rows=[];
      keysAll().forEach(k=>{
        if(hidden[k]){dots[k].setAttribute('opacity','0');return;}
        const v=cfg.series[k].data[idx]; const y=yAt(v,sc);
        dots[k].setAttribute('cx',x); dots[k].setAttribute('cy',y); dots[k].setAttribute('opacity','1');
        rows.push('<div class="row"><span class="dot" style="background:'+cfg.series[k].color+'"></span>'+cfg.series[k].name+' <b>'+metric().fmt(v)+'</b></div>');
      });
      tip.innerHTML='<div class="ep">'+(cfg.xTitle||'')+' '+cfg.labels[idx]+'</div>'+rows.join('');
      // clamp horizontally within wrap (mobile-safe)
      const wr=wrap.getBoundingClientRect(); const px=x/VBW*wr.width; const tw=tip.getBoundingClientRect().width;
      tip.style.left=clamp(px, tw/2+4, wr.width-tw/2-4)+'px';
    }
    function onMove(cx){ if(!cur)return; let idx=Math.round(clamp(dataXFromClient(cx),cur.i0,cur.i1)); idx=clamp(idx,0,cfg.labels.length-1); lastIdx=idx; gHover.setAttribute('opacity','1'); tip.style.opacity='1'; moveHover(idx,cur); }
    const onLeave=()=>{ lastIdx=null; gHover.setAttribute('opacity','0'); tip.style.opacity='0'; };
    svg.addEventListener('pointermove',e=>onMove(e.clientX));
    svg.addEventListener('pointerdown',e=>onMove(e.clientX));
    svg.addEventListener('pointerleave',onLeave);
    const tX=e=>{var t=(e.touches&&e.touches[0])||(e.changedTouches&&e.changedTouches[0]);return t?t.clientX:null;};
    svg.addEventListener('touchstart',e=>{var x=tX(e);if(x!=null)onMove(x);},{passive:true});
    svg.addEventListener('touchmove',e=>{var x=tX(e);if(x!=null)onMove(x);},{passive:true});
    // touch: keep last value visible (mobile-friendly); no hide on touchend

    cur=target(); applyAll(cur);
    const io=new IntersectionObserver(ents=>{ents.forEach(en=>{if(en.isIntersecting&&!entered){entered=true;drawIn(keysOn(),1000);io.disconnect();}});},{threshold:0.25});
    io.observe(host);
  }

  /* ---------------- BAR CHART ---------------- */
  function bar(host, cfg){
    const VBW=760, RH=36, PADT=6, LBLW=188, VALW=64;
    let items=cfg.items.map((d,i)=>({...d,_i:i}));
    let sort=cfg.defaultSort||'value', entered=false;
    const total=cfg.total||items.reduce((a,b)=>a+b.value,0);
    const VBH=PADT*2+items.length*RH, barX=LBLW+8, barMaxW=VBW-barX-VALW;
    const fmt=cfg.fmt||(v=>v.toLocaleString());
    const unit=cfg.unit||'';

    const head=H('div',{class:'rafi-head'},host);
    const ctr=H('div',{class:'rafi-ctrls'},head);
    const seg=H('div',{class:'rafi-seg'},ctr);
    const bVal=H('button',{class:sort==='value'?'on':''},seg); bVal.textContent=cfg.valueLabel||'By value';
    const bAz=H('button',{class:sort==='az'?'on':''},seg); bAz.textContent='A → Z';
    const seg2=H('div',{class:'rafi-seg'},ctr);
    const bReplay=H('button',null,seg2); bReplay.textContent='↻ Replay';
    const wrap=H('div',{class:'rafi-svg-wrap'},host);
    const svg=$('svg',{class:'rafi-svg',viewBox:'0 0 '+VBW+' '+VBH,preserveAspectRatio:'xMidYMid meet'},wrap);
    const tip=H('div',{class:'rafi-tip'},wrap);
    if(cfg.caption){ const c=H('div',{class:'rafi-cap'},host); c.textContent=cfg.caption; }

    const max=Math.max(...items.map(d=>d.value));
    const rows={};
    items.forEach(d=>{
      const g=$('g',{class:'rafi-bar-row'+(d.low?' low':'')},svg);
      const lbl=$('text',{class:'lbl',x:LBLW,y:0,'text-anchor':'end'},g); lbl.textContent=d.label;
      const tr=$('rect',{x:barX,y:0,height:14,rx:4,fill:'var(--border,#E5E5E2)'},g);
      const rc=$('rect',{class:'rafi-bar-rect',x:barX,y:0,height:14,rx:4,width:0,fill:d.low?'var(--hl,#D97706)':'var(--ink,#2d2d2d)'},g);
      const val=$('text',{class:'val',x:VBW,y:0,'text-anchor':'end'},g); val.textContent=fmt(d.value)+unit;
      rows[d._i]={g,lbl,tr,rc,val};
      const show=(cx,cy)=>{tip.innerHTML='<div class="ep">'+d.label+'</div><div class="row"><b>'+fmt(d.value)+unit+'</b>'+(cfg.valueWord?' '+cfg.valueWord:'')+'</div><div class="row">'+(d.value/max*100).toFixed(0)+'% of max'+(cfg.showShare!==false?' &middot; '+(d.value/total*100).toFixed(1)+'% of set':'')+'</div>';
        const wr=wrap.getBoundingClientRect(); const tw=tip.getBoundingClientRect().width||120;
        tip.style.left=clamp(cx-wr.left,tw/2+4,wr.width-tw/2-4)+'px'; tip.style.top=clamp(cy-wr.top-8,2,wr.height)+'px'; tip.style.opacity='1';};
      g.addEventListener('pointermove',e=>show(e.clientX,e.clientY));
      g.addEventListener('pointerleave',()=>tip.style.opacity='0');
      g.addEventListener('touchstart',e=>{var t=(e.touches&&e.touches[0])||(e.changedTouches&&e.changedTouches[0]);if(t)show(t.clientX,t.clientY);},{passive:true});
    });

    function layout(animateW){
      const order=items.slice();
      if(sort==='az') order.sort((a,b)=>a.label.localeCompare(b.label));
      else order.sort((a,b)=>b.value-a.value);
      order.forEach((d,pos)=>{
        const o=rows[d._i], y=PADT+pos*RH;
        o.g.setAttribute('transform','translate(0,'+y+')');
        o.lbl.setAttribute('y',RH/2+4); o.tr.setAttribute('y',RH/2-7); o.tr.setAttribute('width',barMaxW);
        o.rc.setAttribute('y',RH/2-7); o.val.setAttribute('y',RH/2+4);
        const w=(d.value/max)*barMaxW;
        if(animateW){o.rc.setAttribute('width',0);o.rc.style.transition='none';
          requestAnimationFrame(()=>{o.rc.style.transition='width .8s cubic-bezier(.4,0,.2,1) '+(pos*0.05)+'s';o.rc.setAttribute('width',w.toFixed(1));});}
        else o.rc.setAttribute('width',w.toFixed(1));
      });
    }
    bVal.onclick=()=>{sort='value';bVal.classList.add('on');bAz.classList.remove('on');layout(false);};
    bAz.onclick=()=>{sort='az';bAz.classList.add('on');bVal.classList.remove('on');layout(false);};
    bReplay.onclick=()=>layout(true);

    layout(false);
    Object.values(rows).forEach(o=>o.rc.setAttribute('width',0));
    const io=new IntersectionObserver(ents=>{ents.forEach(en=>{if(en.isIntersecting&&!entered){entered=true;layout(true);io.disconnect();}});},{threshold:0.2});
    io.observe(host);
  }

  window.RafiChart={line,bar};
})();
