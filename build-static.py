"""
Renders the PHP app-shell in v7/ into plain HTML in dist/.
The PHP here only does four things (include, echo $version, the $page
comparison in the sidebar, and one foreach over blog.json), so it is
expanded directly rather than shelling out to a PHP binary.
"""
import json, os, re, shutil

SRC  = 'v7'
OUT  = 'dist'
VERSION = '1'

def read(p):
    return open(os.path.join(SRC, p), encoding='utf-8').read()

# ---------- sidebar, once per page (the active item changes) ----------
sidebar_tpl = read('sidebar.php')

def sidebar_for(page):
    def active(m):
        return 'active' if m.group(1) == page else ''
    return re.sub(r'<\?php if \(\$page == "(\w+)"\) \{ echo "active"; \} \?>', active, sidebar_tpl)

# ---------- the blog list, normally built by PHP from blog.json ----------
def blog_list_html():
    posts = json.load(open(os.path.join(SRC, 'data/blog.json'), encoding='utf-8'))
    out = []
    for p in posts:
        out.append(
            '\n                <button class="btn btn-blog" id="blogmenu" onclick="blogActive(this)" data-id="'
            + p['id'] + '">\n'
            '                    <span class="badge blog-badge ' + p['badge'] + '">'
            + p['category'] + '</span><br>\n'
            '                    ' + p['title'] + '<br>\n'
            '                    <span style="font-weight: lighter;">' + p['date'] + '</span>\n'
            '                </button>')
    return ''.join(out)

# content/ is split into pages/ (site-level shells) and projects/
# (case studies); content/blog/ (actual blog posts) is handled separately
# below. Keep this in sync with PAGE_CONTENT_DIR in main.js.
PAGE_CONTENT_DIR = {'home': 'pages', 'resume': 'pages', 'contact': 'pages',
                     'course': 'pages', 'blog': 'pages'}

def content_rel(page):
    """'home' -> 'pages/home', 'idfest' -> 'projects/idfest'."""
    return PAGE_CONTENT_DIR.get(page, 'projects') + '/' + page

def render_fragment(rel):
    """rel like 'pages/home' or 'projects/idfest'."""
    s = read('content/' + rel + '.php')
    if rel == 'pages/blog':
        s = re.sub(r'<\?php.*?\?>', blog_list_html(), s, flags=re.S)
    return s

# ---------- pages ----------
entries = [f[:-4] for f in sorted(os.listdir(SRC))
           if f.endswith('.php') and f not in ('sidebar.php', 'conf.php', 'router.php')]

os.makedirs(OUT, exist_ok=True)
for e in entries:
    s = read(e + '.php')
    page = 'home' if e == 'index' else e
    s = s.replace('<?php include "conf.php"; ?>\n', '')
    s = s.replace('<?php include "conf.php"; ?>', '')
    s = s.replace('<?php echo $version; ?>', VERSION)
    s = re.sub(r'<\?php\s*\$page = "\w+";\s*include\(\'sidebar\.php\'\);\s*\?>',
               lambda m: sidebar_for(page), s, flags=re.S)
    s = re.sub(r"<\?php include\(__DIR__ \. '/content/([\w/]+)\.php'\); \?>",
               lambda m: render_fragment(m.group(1)), s)
    # the shell fetches .html fragments once there is no PHP to run them
    s = s.replace('.php"', '.html"')
    assert '<?php' not in s, e
    open(os.path.join(OUT, e + '.html'), 'w', encoding='utf-8').write(s)

# ---------- fragments the shell fetches ----------
for sub in ('pages', 'projects'):
    os.makedirs(os.path.join(OUT, 'content', sub), exist_ok=True)
    for f in sorted(os.listdir(os.path.join(SRC, 'content', sub))):
        if f.endswith('.php'):
            name = f[:-4]
            rel = sub + '/' + name
            open(os.path.join(OUT, 'content', sub, name + '.html'), 'w', encoding='utf-8').write(render_fragment(rel))

os.makedirs(os.path.join(OUT, 'content/blog'), exist_ok=True)
for f in sorted(os.listdir(os.path.join(SRC, 'content/blog'))):
    if f.endswith('.php'):
        shutil.copyfile(os.path.join(SRC, 'content/blog', f),
                        os.path.join(OUT, 'content/blog', f[:-4] + '.html'))

# ---------- code assets ----------
for d in ['data', 'js']:
    s_dir = os.path.join(SRC, d)
    if os.path.isdir(s_dir):
        shutil.copytree(s_dir, os.path.join(OUT, d), dirs_exist_ok=True)
for f in ['main.css', 'main.js', 'icon.js']:
    shutil.copyfile(os.path.join(SRC, f), os.path.join(OUT, f))

# ---------- point the shell at .html fragments ----------
mj = os.path.join(OUT, 'main.js')
s = open(mj, encoding='utf-8').read()
s = s.replace('"content/" + dir + "/" + id + ".php"', '"content/" + dir + "/" + id + ".html"')
open(mj, 'w', encoding='utf-8').write(s)

# a visitor landing on /resume.html (rather than the clean /resume) must
# still resolve to the "resume" page id
s = s.replace('.replace(/^\\/|\\.php$/g, "")', '.replace(/^\\/|\\.(php|html)$/g, "")')
s = s.replace('path === "/index.php"', 'path === "/index.php" || path === "/index.html"')
s = s.replace('.replace(".php", "")', '.replace(/\\.(php|html)$/, "")')
open(mj, 'w', encoding='utf-8').write(s)

bj = os.path.join(OUT, 'js/blog.js')
s = open(bj, encoding='utf-8').read()
s = s.replace('fetch("content/blog/" + id + ".php")', 'fetch("content/blog/" + id + ".html")')
open(bj, 'w', encoding='utf-8').write(s)

# Cloudflare Pages serves /resume from resume.html on its own; this makes the
# behaviour explicit and gives every unknown path the home page.
open(os.path.join(OUT, '_redirects'), 'w', encoding='utf-8').write(
    "/index    /    301\n")

n_pages_frag = len([f for f in os.listdir(os.path.join(OUT, 'content/pages')) if f.endswith('.html')])
n_proj_frag = len([f for f in os.listdir(os.path.join(OUT, 'content/projects')) if f.endswith('.html')])
print("pages     :", len(entries))
print("fragments :", n_pages_frag, "pages +", n_proj_frag, "projects +",
      len(os.listdir(os.path.join(OUT, 'content/blog'))), "blog")
print("php left  :", sum('<?php' in open(os.path.join(r, f), encoding='utf-8', errors='ignore').read()
                          for r, _, fs in os.walk(OUT) for f in fs if f.endswith(('.html', '.js', '.css'))))

# ---------- copy only the media the built pages actually reference ----------
pat = re.compile(r"""['"(]?((?:image|icon|skills|resources|vendor)/[^'"\)\s>]+\.[A-Za-z0-9]{2,5})""")
refs = set()
for root, _, files in os.walk(OUT):
    for f in files:
        if f.endswith(('.html', '.js', '.css', '.json')):
            refs.update(pat.findall(open(os.path.join(root, f), encoding='utf-8', errors='ignore').read()))

copied = missing = 0
total = 0
for rel in sorted(refs):
    src_file = os.path.join(SRC, rel)
    if not os.path.exists(src_file):
        missing += 1
        continue
    dst = os.path.join(OUT, rel)
    os.makedirs(os.path.dirname(dst), exist_ok=True)
    shutil.copyfile(src_file, dst)
    total += os.path.getsize(dst)
    copied += 1

print("media referenced :", len(refs))
print("media copied     :", copied, "(%.1f MB)" % (total / 1e6))
print("media missing    :", missing, "(fall back to initials tiles)")
grand = sum(os.path.getsize(os.path.join(r, f)) for r, _, fs in os.walk(OUT) for f in fs)
print("dist total       : %.1f MB in %d files" % (grand / 1e6, sum(len(fs) for _, _, fs in os.walk(OUT))))
