<div class="sticky-top d-flex align-items-center">
    <div class="burger-icon">
        <button type="button" class="btn btn-main d-flex justify-content-between align-items-center"
            onclick="burgerToogle()">
            <menu-icon class="burger-icon-data"></menu-icon>
        </button>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="mdcontent">
        <div class="blog-content-header">
            <div>
                <span class="badge blog-badge badge-blue">Java 17</span>
                <span class="badge blog-badge badge-green">Doubly Linked List</span>
                <span class="badge blog-badge badge-purple">Next.js</span>
                <span class="badge blog-badge badge-orange">TypeScript</span>
                <span class="badge blog-badge badge-neutral">WIA1002 Coursework</span>
            </div>
            <h1>Large Number Arithmetic</h1>
            <br>
            <span>Arithmetic on numbers far larger than any built-in type can hold, using a doubly linked list where every digit is its own node. A Java engine does the maths; a Next.js visualizer walks the algorithm one step at a time so you can watch the carries move.</span>
            <div class="p-meta"><span class="p-meta-item"><span class="p-meta-k">Status</span><span class="p-meta-v">Complete</span></span><span class="p-meta-item"><span class="p-meta-k">Year</span><span class="p-meta-v">2026</span></span><span class="p-meta-item"><span class="p-meta-k">Role</span><span class="p-meta-v">Team Project</span></span><span class="p-meta-item"><span class="p-meta-k">Course</span><span class="p-meta-v">WIA1002 Data Structures</span></span></div>
            <a href="https://github.com/rafiarsya07/WIA1002_LargeNumberArithmetic" target="_blank" rel="noopener" class="ext-link">View on GitHub<svg class="ext-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M7 17 17 7M8 7h9v9"/></svg></a>
            <div class="contributors-byline">
<a class="contributor-chip" href="https://www.linkedin.com/in/abqarynasution/" target="_blank" rel="noopener noreferrer">
<img class="contributor-chip-avatar" src="image/assets/largenumber/contributor-abqary.png" alt="Abqary Nasution" loading="lazy" decoding="async">
<span class="contributor-chip-name">Abqary Nasution</span>
</a>
<a class="contributor-chip" href="https://www.linkedin.com/in/gema-radya-prabowo-2ba8392b4/" target="_blank" rel="noopener noreferrer">
<img class="contributor-chip-avatar" src="image/assets/largenumber/contributor-gema.png" alt="Gema Radya Prabowo" loading="lazy" decoding="async">
<span class="contributor-chip-name">Gema Radya Prabowo</span>
</a>
<a class="contributor-chip" href="https://www.linkedin.com/in/ilhamsetiabudi/" target="_blank" rel="noopener noreferrer">
<img class="contributor-chip-avatar" src="image/assets/largenumber/contributor-ilham.png" alt="Ilham Narendra Setiabudi" loading="lazy" decoding="async">
<span class="contributor-chip-name">Ilham Narendra Setiabudi</span>
</a>
<span class="contributor-chip">
<img class="contributor-chip-avatar" src="image/assets/largenumber/contributor-dafi.png" alt="Dafi Atha" loading="lazy" decoding="async">
<span class="contributor-chip-name">Dafi Atha</span>
</span>
            </div>
        </div>
        <div style="border-top: solid 1px #acb8c0; margin-bottom: 10px;"></div>
        <h3>01 The Problem</h3>
        <div class="blog-content-body">
<p>A Java <code class="inline">long</code> stops at 9,223,372,036,854,775,807. Ask it for one more and it silently wraps around to a negative number. That ceiling is a property of the fixed 64 bits the type is given, not of arithmetic itself &mdash; the maths keeps working, the container runs out.</p>
<p>The way around it is to stop storing a number as a machine word and start storing it as a structure you control. This project stores each decimal digit in its own node of a doubly linked list, so the only limit left is memory. <code class="inline">1234</code> becomes:</p>
<pre class="p-math-formula">[1] &lt;-&gt; [2] &lt;-&gt; [3] &lt;-&gt; [4]
 head              tail</pre>
<p>Doubly linked matters here. Column arithmetic runs right to left, from the least significant digit &mdash; so addition, subtraction and multiplication all start at <code class="inline">tail</code> and walk backwards through <code class="inline">prev</code>. Division runs the other way, left to right from <code class="inline">head</code>. A singly linked list would force one of those directions to be a reversal or a second pass.</p>
        </div>
        <br>
        <h3>02 The List</h3>
        <div class="blog-content-body">
<p><code class="inline">DoublyLinkedList</code> holds <code class="inline">head</code>, <code class="inline">tail</code>, <code class="inline">size</code> and an <code class="inline">isNegative</code> flag, plus the small set of operations the arithmetic actually needs:</p>
<ul>
<li><b>addBack(digit)</b> and <b>addFront(digit)</b>: append while parsing input, prepend while building a result right to left.</li>
<li><b>parse(String)</b>: turn <code class="inline">"1234"</code> into a four-node list in one pass.</li>
<li><b>stripLeadingZeros()</b>: <code class="inline">005</code> and <code class="inline">5</code> have to compare and print identically, so zeros are trimmed after every parse and every operation.</li>
<li><b>compare(a, b)</b>: length first, then digit by digit from the head. Used by subtraction to decide which operand is larger, and by division to know when the remainder has dropped below the divisor.</li>
<li><b>copy(list)</b> and <b>appendZero(list)</b>: division and multiplication both need scratch copies and place-value shifts without mutating the operands.</li>
</ul>
<p>Nothing here converts back to a primitive at any point. A 500-digit number is never an <code class="inline">int</code>, not even briefly &mdash; the intermediate values in every algorithm below are lists too.</p>
        </div>
        <br>
        <h3>03 The Four Operations</h3>
        <div class="blog-content-body">
<p>Addition, subtraction and multiplication are column arithmetic done by hand, in code. Division is the one that needed real thought, because a quotient does not necessarily terminate.</p>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">01</span><span class="p-math-title">Addition and the Carry Walk</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Algorithm</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula">i = a.tail,  j = b.tail,  carry = 0,  result = empty

while i != null or j != null or carry != 0:
        sum   = carry
        if i != null: sum += i.digit;  i = i.prev
        if j != null: sum += j.digit;  j = j.prev

        result.addFront(sum % 10)      # new digit goes on the LEFT
        carry = sum / 10               # 0 or 1</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">Two details carry the whole method. First, the loop condition includes <code class="inline">carry != 0</code>, not just "both lists have digits left" &mdash; without it <code class="inline">999 + 1</code> produces <code class="inline">000</code> and drops the leading 1, because the final carry has nowhere to go once both operands are exhausted. Second, every result digit is added with <code class="inline">addFront</code>, not <code class="inline">addBack</code>. The scan runs right to left, so each digit produced is more significant than the last and belongs in front of what has already been built. Using <code class="inline">addBack</code> here would silently produce the answer reversed.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example">   a = 999          b = 1

step 1:  9 + 1 + 0  = 10   ->  addFront(0)   carry 1     result: 0
step 2:  9 + _ + 1  = 10   ->  addFront(0)   carry 1     result: 00
step 3:  9 + _ + 1  = 10   ->  addFront(0)   carry 1     result: 000
step 4:  _ + _ + 1  =  1   ->  addFront(1)   carry 0     result: 1000
                                     ^ the loop only reached
                                       step 4 because of the
                                       "or carry != 0" clause</pre></div></div></div></div></div>
<div class="p-math-block"><div class="p-math-head"><div class="p-math-head-left"><span class="p-math-index">02</span><span class="p-math-title">Division by Repeated Scaled Subtraction</span></div><div class="p-math-tabs"><button class="p-math-tab active" data-tab="formula"><span class="p-math-tab-dot"></span>Algorithm</button><button class="p-math-tab" data-tab="explained"><span class="p-math-tab-dot"></span>Explained</button><button class="p-math-tab" data-tab="example"><span class="p-math-tab-dot"></span>Worked Example</button></div></div><div class="p-math-body"><div class="p-math-panel active" data-panel="formula"><div class="p-math-formula-wrap"><div class="p-math-scroll"><pre class="p-math-formula"># INTEGER PART
remainder = a,  quotient = 0
while compare(remainder, b) &gt;= 0:
        # largest power of ten whose scaled divisor still fits
        zeroCount = 0
        while compare(remainder, b * 10^(zeroCount+1)) &gt;= 0:
                zeroCount++

        scaled = b * 10^zeroCount
        digitCount = 0
        while compare(remainder, scaled) &gt;= 0:
                remainder = subtract(remainder, scaled)
                digitCount++

        quotient += digitCount * 10^zeroCount

# DECIMAL PART, up to 20 places
for place in 1..20:
        if isZero(remainder): break        # exact division, stop early
        remainder = appendZero(remainder)  # multiply by 10
        d = 0
        while compare(remainder, b) &gt;= 0:
                remainder = subtract(remainder, b)
                d++
        emit decimal digit d</pre></div></div></div><div class="p-math-panel" data-panel="explained"><div class="p-math-explained"><p class="p-math-desc">There is no division primitive available here, so division is built out of the subtraction that already exists. The naive version &mdash; subtract the divisor one at a time and count &mdash; is correct but hopeless: dividing a 30-digit number by 7 would loop more times than there are atoms worth waiting for. The fix is to scale first. Before subtracting, the divisor is shifted left by appending zeros until one more zero would overshoot the remainder; that scaled divisor is then subtracted repeatedly, which can only happen between one and nine times, and contributes <code class="inline">digitCount &times; 10^zeroCount</code> to the quotient. Each outer pass produces one quotient digit and shrinks the remainder by an order of magnitude, so the work is proportional to the number of digits rather than to the value.</p><p class="p-math-desc">The decimal expansion reuses the same machinery. Appending a zero to the remainder is a multiplication by ten that costs one node, and each pass then yields exactly one decimal digit. It is capped at 20 places because a repeating expansion like <code class="inline">1 / 3</code> never terminates &mdash; and it breaks early when the remainder hits zero, so <code class="inline">10 / 4</code> prints <code class="inline">2.5</code> rather than <code class="inline">2.50000000000000000000</code>.</p></div></div><div class="p-math-panel" data-panel="example"><div class="p-math-example-wrap"><div class="p-math-example-scroll"><pre class="p-math-example">   a = 1234        b = 7

INTEGER PART
  remainder 1234, b*100 = 700 fits, b*1000 = 7000 does not
     -> zeroCount = 2, scaled = 700
     subtract 700 once -> remainder 534, digitCount 1
     quotient += 1 * 100                       quotient = 100

  remainder 534, scaled = 70  (zeroCount = 1)
     subtract 70 seven times -> remainder 44,  digitCount 7
     quotient += 7 * 10                        quotient = 170

  remainder 44, scaled = 7   (zeroCount = 0)
     subtract 7 six times   -> remainder 2,    digitCount 6
     quotient += 6                             quotient = 176

  remainder 2 &lt; 7, integer part done           -> 176

DECIMAL PART
  place 1: remainder 20 -> 7 fits twice -> digit 2, remainder 6
  place 2: remainder 60 -> 7 fits 8x    -> digit 8, remainder 4
  place 3: remainder 40 -> 7 fits 5x    -> digit 5, remainder 5
  ...                                      1234 / 7 = 176.285714285714285714</pre></div></div></div></div></div>
<p>Subtraction takes the same shape as addition with a borrow instead of a carry, and always subtracts the smaller absolute value from the larger &mdash; <code class="inline">compare</code> decides which is which, and the sign is set on the result afterwards. Multiplication builds one partial product per multiplier digit, shifts it by appending <code class="inline">shiftCount</code> zeros for its place value, and adds the partials together with the addition routine above; a zero multiplier digit short-circuits to a shifted zero instead of running a pointless inner loop.</p>
        </div>
        <br>
        <h3>04 Edge Cases</h3>
        <div class="blog-content-body">
<p>Most of the bugs in a project like this live in the inputs nobody demonstrates:</p>
<ul>
<li><b>Leading zeros</b>: <code class="inline">005</code> parses to three nodes and has to behave exactly like <code class="inline">5</code>. <code class="inline">stripLeadingZeros()</code> runs after parsing and after every operation, and deliberately leaves a single <code class="inline">0</code> standing rather than emptying the list.</li>
<li><b>Division by zero</b>: caught before the loop starts and reported as an error message, not an exception trace &mdash; an empty divisor would otherwise make the outer <code class="inline">while</code> spin forever, since the remainder never shrinks.</li>
<li><b>Result shorter than the operands</b>: <code class="inline">1000 - 999</code> is one digit wide. Borrow chains leave a run of leading zeros that has to be trimmed before printing.</li>
<li><b>Invalid input</b>: <code class="inline">Main</code> re-prompts until the string is a valid non-negative whole number, so a stray letter never reaches the engine.</li>
<li><b>Exact division</b>: the decimal loop breaks the moment the remainder reaches zero, so terminating quotients print at their natural length.</li>
</ul>
        </div>
        <br>
        <h3>05 The Visualizer</h3>
        <div class="blog-content-body">
<p>An algorithm like this is hard to read from source alone &mdash; the interesting part is the movement, and source code holds still. So the second half of the project is a Next.js app that animates it: nodes render as boxes joined by <code class="inline">&lt;-&gt;</code> arrows, the active pointer highlights as it walks, carries and borrows appear above the column being worked on, and the result list grows a digit at a time.</p>
<p>The visualizer does not call the Java code. <code class="inline">lib/arithmetic.ts</code> is a second implementation of the same four operations in TypeScript, written to expose each intermediate step as a state the UI can render, with Framer Motion driving the transitions between them. Keeping them separate means the Java engine stays a clean coursework submission rather than being contorted into emitting animation frames.</p>
        </div>
        <br>
        <h3>06 Project Structure</h3>
        <div class="blog-content-body">
<p class="rf-media-lead">Two runnable programs in one repository: a Java CLI and a Next.js app.</p>
<div class="project-tree">WIA1002_LargeNumberArithmetic/
├── <span class="pt-dir">src/</span>                    <span class="pt-comment"># Java engine (the coursework submission)</span>
│   ├── Node.java          <span class="pt-comment"># one digit + prev/next</span>
│   ├── DoublyLinkedList.java <span class="pt-comment"># parse, compare, copy, strip, shift</span>
│   ├── ArithmeticEngine.java <span class="pt-comment"># add, subtract, multiply, divide</span>
│   └── Main.java          <span class="pt-comment"># input validation + CLI output</span>
├── <span class="pt-dir">lib/</span>
│   └── arithmetic.ts      <span class="pt-comment"># TS engine, step-by-step for the UI</span>
├── <span class="pt-dir">components/</span>
│   ├── DLLNode.tsx        <span class="pt-comment"># a single digit box</span>
│   └── DLLDiagram.tsx     <span class="pt-comment"># the animated list</span>
├── <span class="pt-dir">app/</span>                    <span class="pt-comment"># Next.js App Router page + globals</span>
└── tailwind.config.ts</div>
<p>Run the coursework version with <code class="inline">javac src/*.java</code> then <code class="inline">java src.Main</code>, which prompts for <code class="inline">m</code> and <code class="inline">n</code> and prints all four results. Run the visualizer with <code class="inline">npm install</code> and <code class="inline">npm run dev</code>.</p>
        </div>
        <br>
        <div class="d-flex">
            <a href="/project" class="btn btn-main button-border d-flex align-items-center">
                <span class="menu-icon"><back-icon class="menu-icon-data"></back-icon></span>
                <span>All Projects</span>
            </a>
        </div>
        <br><br>
    </div>
</div>
