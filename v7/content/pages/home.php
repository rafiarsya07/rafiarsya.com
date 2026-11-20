<div class="sticky-top d-flex align-items-center">
    <div class="burger-icon">
        <button type="button" class="btn btn-main d-flex justify-content-between align-items-center"
            onclick="burgerToogle()">
            <menu-icon class="burger-icon-data"></menu-icon>
        </button>
    </div>
</div>
<div class="d-flex justify-content-center">
    <div class="content">
        <div class="blob-wrapper" id="blob-wrapper">
            <div class="blob"></div>
        </div>

        <p class="about-section">
            <span class="opening-about-section">Hi there! I'm Rafi</span><br>
            I'm a <span class="marksalmon">Computer Science (Software Engineering) student who builds things for
                the web</span> at the University of Malaya. I got into programming through web development back in
            school, and I've been building ever since.
        </p>

        <p class="about-section">
            I'm pursuing my <span class="markblue">Bachelor of Computer Science (Software Engineering)</span>
            at <span class="markgreen">University of Malaya</span>. Alongside that I'm active in student
            organizations: <span class="marksalmon">Technical Executive Committee</span> at PEKOM, the Computer
            Science Society of the <a class="textlink" href="https://fsktm.um.edu.my/" target="_blank"
                rel="noopener">Faculty of Computer Science &amp; IT</a>, and
            <span class="marksalmon">Head of Website Division</span> in the Data &amp; Information System Bureau at
            PPI Malaysia, where I own the association's official website end to end.
        </p>

        <p class="about-section">
            Beyond that I lead as <span class="highlightv1">Head of Department</span> for the IDFEST Art Exhibition
            at Universiti Malaya. I was also the <span class="highlightv1">student representative of
                Universiti Malaya</span> on an outbound programme to Institut Teknologi Batam in Indonesia, where I
            led a group of 28 students and delivered the student speech. Closer to home, I served as a
            <span class="highlightv1">Student Buddy</span> for FSKTM's Inbound Mobility Programme 2026, hosting
            Chulalongkorn University students in Kuala Lumpur.
        </p>

        <p class="about-section">
            Outside of code I enjoy sharing knowledge and explaining technical topics simply, which is mostly why
            the blog exists. Want to talk shop, work on something together, or just say hi? Let's build something.
        </p>

        <div class="row">
            <div class="col-6 col-sm-5 col-lg-4 col-xl-3">
                <a type="button" href="/resume" class="btn btn-main btn-max d-flex align-items-center button-border">
                    <span class="menu-icon"><resume-icon class="menu-icon-data"></resume-icon></span>
                    <span>My Resume</span>
                </a>
            </div>
            <div class="col-6 col-sm-5 col-lg-4 col-xl-3">
                <a type="button" href="/contact" class="btn btn-main btn-max d-flex align-items-center button-border">
                    <span class="menu-icon"><contact-icon class="menu-icon-data"></contact-icon></span>
                    <span>Contact Me</span>
                </a>
            </div>
        </div>
        <br>

        <div class="about-section">
            <p class="text-silent">Social</p>
            <a href="https://github.com/rafiarsya07" target="_blank" rel="noopener noreferrer" type="button"
                class="btn btn-main btn-maxv2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <svg data-src="icon/github.svg" class="menu-ico"></svg><span>GitHub</span>
                </div>
                <div><arrow-icon class="togo-icon"></arrow-icon></div>
            </a>
            <a href="https://www.linkedin.com/in/muhammad-rafi-arsya-557335394/" target="_blank" rel="noopener noreferrer"
                type="button" class="btn btn-main btn-maxv2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <svg data-src="icon/linkedin.svg" class="menu-ico"></svg><span>LinkedIn</span>
                </div>
                <div><arrow-icon class="togo-icon"></arrow-icon></div>
            </a>
            <a href="https://www.instagram.com/rarsya.03/" target="_blank" rel="noopener noreferrer" type="button"
                class="btn btn-main btn-maxv2 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <svg data-src="icon/instagram.svg" class="menu-ico"></svg><span>Instagram</span>
                </div>
                <div><arrow-icon class="togo-icon"></arrow-icon></div>
            </a>
        </div>
        <br>

        <div class="about-section" style="min-width: 300px">
            <div class="d-flex justify-content-between align-items-center">
                <p class="text-silent">Based</p>
                <div class="toggle-container">
                    <span class="role" id="current-text">Current</span>
                    <div class="toogle-switch" data-active="current">
                        <div class="toogle-switch-handle">
                            <span class="menu-iconv2">
                                <currentbased-icon class="menu-icon-datav2"></currentbased-icon>
                            </span>
                        </div>
                    </div>
                    <span class="role inactive" id="main-text">Home</span>
                </div>
            </div>

            <!-- The map is display only: a transparent layer sits over the
                 iframe so it cannot be panned, zoomed or searched. -->
            <div class="map-frame">
                <iframe id="based-map" title="Map" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                    src="https://maps.google.com/maps?q=Petaling%20Jaya%2C%20Selangor%2C%20Malaysia&z=12&output=embed"></iframe>
                <div class="map-lock" aria-hidden="true"></div>
            </div>
            <p class="text-silent subtitle map-label" id="based-label">Petaling Jaya, Selangor, Malaysia</p>
        </div>

        <div class="about-section xp-group">
            <p class="text-silent xp-title">Education</p>
            <ul class="xp-list">
                <li class="xp-item">
                    <img src="icon/UM.png" alt="Universiti Malaya" class="xp-logo" loading="lazy" />
                    <div class="xp-body">
                        <div class="xp-top"><p class="xp-role">Bachelor of Computer Science (Software Engineering)</p><span class="xp-year">2025 – now</span></div>
                        <a class="xp-org textlink" href="https://study.um.edu.my/" target="_blank" rel="noopener noreferrer">Universiti Malaya<arrow-icon class="togo-icon"></arrow-icon></a>
                        <p class="xp-desc">Year 2. Focus on full-stack development, data and software engineering.</p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="about-section xp-group">
            <p class="text-silent xp-title">Experience</p>
            <ul class="xp-list">
                <li class="xp-item">
                    <img src="icon/pekom.png" alt="PEKOM" class="xp-logo" loading="lazy" />
                    <div class="xp-body">
                        <div class="xp-top"><p class="xp-role">Technical Executive Committee, Website Division</p><span class="xp-year">2026</span></div>
                        <a class="xp-org textlink" href="https://pekomum.org" target="_blank" rel="noopener noreferrer">PEKOM, Computer Science Society of UM<arrow-icon class="togo-icon"></arrow-icon></a>
                        <p class="xp-desc">Built the society's official website, <a class="textlink" href="/pekom">pekomum.org</a>, in three languages.</p>
                    </div>
                </li>
                <li class="xp-item">
                    <img src="icon/ppim.png" alt="PPI Malaysia" class="xp-logo" loading="lazy" />
                    <div class="xp-body">
                        <div class="xp-top"><p class="xp-role">Head of Website Division, Data &amp; Information System Bureau</p><span class="xp-year">2026</span></div>
                        <a class="xp-org textlink" href="https://ppimalaysia.id" target="_blank" rel="noopener noreferrer">PPI Malaysia<arrow-icon class="togo-icon"></arrow-icon></a>
                        <p class="xp-desc">Own the association's website and its event sites, including SENARA and BriskWalk.</p>
                    </div>
                </li>
                <li class="xp-item">
                    <img src="icon/ppium.png" alt="PPI UM" class="xp-logo" loading="lazy" />
                    <div class="xp-body">
                        <div class="xp-top"><p class="xp-role">Website Development Committee, IDFEST 2026</p><span class="xp-year">2026</span></div>
                        <a class="xp-org textlink" href="https://idfest.ppiunimalaya.id" target="_blank" rel="noopener noreferrer">PPI Universiti Malaya<arrow-icon class="togo-icon"></arrow-icon></a>
                        <p class="xp-desc">Built the festival website in Next.js from the team's Figma designs.</p>
                    </div>
                </li>
                <li class="xp-item">
                    <img src="icon/ppium.png" alt="PPI UM" class="xp-logo" loading="lazy" />
                    <div class="xp-body">
                        <div class="xp-top"><p class="xp-role">Head of Department, Art Exhibition, IDFEST 2026</p><span class="xp-year">2026</span></div>
                        <a class="xp-org textlink" href="https://ppiunimalaya.id" target="_blank" rel="noopener noreferrer">PPI Universiti Malaya<arrow-icon class="togo-icon"></arrow-icon></a>
                        <p class="xp-desc">Led the art exhibition from concept and curation to the event day.</p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="about-section xp-group">
            <p class="text-silent xp-title">Leadership &amp; Activities</p>
            <ul class="xp-list">
                <li class="xp-item">
                    <img src="icon/UM.png" alt="Universiti Malaya" class="xp-logo" loading="lazy" />
                    <div class="xp-body">
                        <div class="xp-top"><p class="xp-role">Student Representative &amp; Group Leader, Outbound Programme</p><span class="xp-year">2026</span></div>
                        <a class="xp-org textlink" href="https://iteba.ac.id/en" target="_blank" rel="noopener noreferrer">Universiti Malaya × ITEBA, Batam, Indonesia<arrow-icon class="togo-icon"></arrow-icon></a>
                        <p class="xp-desc">Represented UM on the outbound trip, led a group of 28 students and gave the student speech.</p>
                    </div>
                </li>
                <li class="xp-item">
                    <img src="icon/ppim.png" alt="PPI Malaysia" class="xp-logo" loading="lazy" />
                    <div class="xp-body">
                        <div class="xp-top"><p class="xp-role">Transportation Team &amp; Field Committee, LARAS</p><span class="xp-year">2026</span></div>
                        <a class="xp-org textlink" href="https://ppimalaysia.id" target="_blank" rel="noopener noreferrer">PPI Malaysia<arrow-icon class="togo-icon"></arrow-icon></a>
                        <p class="xp-desc">Logistics and on-ground coordination on event day.</p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="about-section xp-group">
            <p class="text-silent xp-title">Volunteering</p>
            <ul class="xp-list">
                <li class="xp-item">
                    <img src="icon/UM.png" alt="Universiti Malaya" class="xp-logo" loading="lazy" />
                    <div class="xp-body">
                        <div class="xp-top"><p class="xp-role">Buddy, UM Week of Welcome (UM-WOW)</p><span class="xp-year">2026</span></div>
                        <a class="xp-org textlink" href="https://hep.um.edu.my/umwow" target="_blank" rel="noopener noreferrer">Student Affairs (HEP), Universiti Malaya<arrow-icon class="togo-icon"></arrow-icon></a>
                        <p class="xp-desc">Guided new students through registration, campus and their first days.</p>
                    </div>
                </li>
                <li class="xp-item">
                    <img src="icon/UM.png" alt="Universiti Malaya" class="xp-logo" loading="lazy" />
                    <div class="xp-body">
                        <div class="xp-top"><p class="xp-role">Buddy, Bollywood Glam</p><span class="xp-year">2026</span></div>
                        <a class="xp-org textlink" href="https://fsktm.um.edu.my/" target="_blank" rel="noopener noreferrer">Student Affairs (HEP), FSKTM, Universiti Malaya<arrow-icon class="togo-icon"></arrow-icon></a>
                        <p class="xp-desc">Accompanied graduating undergraduate and PhD students at the faculty's graduation celebration.</p>
                    </div>
                </li>
                <li class="xp-item">
                    <img src="icon/chula.png" alt="Chulalongkorn University" class="xp-logo" loading="lazy" />
                    <div class="xp-body">
                        <div class="xp-top"><p class="xp-role">Student Buddy &amp; Documentation, Inbound Mobility Programme</p><span class="xp-year">2026</span></div>
                        <a class="xp-org textlink" href="https://fsktm.um.edu.my/" target="_blank" rel="noopener noreferrer">Student Affairs (HEP), FSKTM, Universiti Malaya<arrow-icon class="togo-icon"></arrow-icon></a>
                        <p class="xp-desc">Hosted visiting students from Chulalongkorn University for five days and documented the programme.</p>
                    </div>
                </li>
            </ul>
        </div>

        <div class="about-section">
            <div class="text-silent">Skills</div>
            <div class="horizontal">
                <a class="menu-item active" id="core"><span>Core</span></a>
                <a class="menu-item" id="languages"><span>Languages</span></a>
                <a class="menu-item" id="frontend"><span>Frontend</span></a>
                <a class="menu-item" id="backend"><span>Backend</span></a>
                <a class="menu-item" id="data"><span>Databases</span></a>
                <a class="menu-item" id="infra"><span>Infrastructure</span></a>
                <a class="menu-item" id="aiml"><span>AI / ML</span></a>
            </div>
            <hr>
            <div class="menu-item-content">
                <div id="core-content" class="row text-center">
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/typescript.svg" alt="TypeScript" class="imgskills" loading="lazy"><span class="skill-name">TypeScript</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/javascript.svg" alt="JavaScript" class="imgskills" loading="lazy"><span class="skill-name">JavaScript</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/python.svg" alt="Python" class="imgskills" loading="lazy"><span class="skill-name">Python</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/react.svg" alt="React" class="imgskills" loading="lazy"><span class="skill-name">React</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/nextjs.svg" alt="Next.js" class="imgskills" loading="lazy"><span class="skill-name">Next.js</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/nodejs.svg" alt="Node.js" class="imgskills" loading="lazy"><span class="skill-name">Node.js</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/hono.svg" alt="Hono" class="imgskills" loading="lazy"><span class="skill-name">Hono</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/tailwind.svg" alt="Tailwind" class="imgskills" loading="lazy"><span class="skill-name">Tailwind</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/postgresql.svg" alt="PostgreSQL" class="imgskills" loading="lazy"><span class="skill-name">PostgreSQL</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/docker.svg" alt="Docker" class="imgskills" loading="lazy"><span class="skill-name">Docker</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/cloudflare.svg" alt="Cloudflare" class="imgskills" loading="lazy"><span class="skill-name">Cloudflare</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/git.svg" alt="Git" class="imgskills" loading="lazy"><span class="skill-name">Git</span></div>
                </div>
                <div id="languages-content" class="row text-center hidden">
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/typescript.svg" alt="TypeScript" class="imgskills" loading="lazy"><span class="skill-name">TypeScript</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/javascript.svg" alt="JavaScript" class="imgskills" loading="lazy"><span class="skill-name">JavaScript</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/python.svg" alt="Python" class="imgskills" loading="lazy"><span class="skill-name">Python</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/java.svg" alt="Java" class="imgskills" loading="lazy"><span class="skill-name">Java</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/php.svg" alt="PHP" class="imgskills" loading="lazy"><span class="skill-name">PHP</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/bash.svg" alt="Bash" class="imgskills" loading="lazy"><span class="skill-name">Bash</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/latex.svg" alt="LaTeX" class="imgskills" loading="lazy"><span class="skill-name">LaTeX</span></div>
                </div>
                <div id="frontend-content" class="row text-center hidden">
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/react.svg" alt="React" class="imgskills" loading="lazy"><span class="skill-name">React</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/nextjs.svg" alt="Next.js" class="imgskills" loading="lazy"><span class="skill-name">Next.js</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/reactrouter.svg" alt="React Router" class="imgskills" loading="lazy"><span class="skill-name">React Router</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/tailwind.svg" alt="Tailwind" class="imgskills" loading="lazy"><span class="skill-name">Tailwind</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/vite.svg" alt="Vite" class="imgskills" loading="lazy"><span class="skill-name">Vite</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/motion.svg" alt="Motion" class="imgskills" loading="lazy"><span class="skill-name">Motion</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/chartjs.svg" alt="Chart.js" class="imgskills" loading="lazy"><span class="skill-name">Chart.js</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/bootstrap.svg" alt="Bootstrap" class="imgskills" loading="lazy"><span class="skill-name">Bootstrap</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/html.svg" alt="HTML5" class="imgskills" loading="lazy"><span class="skill-name">HTML5</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/css.svg" alt="CSS3" class="imgskills" loading="lazy"><span class="skill-name">CSS3</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/pwa.svg" alt="PWA" class="imgskills" loading="lazy"><span class="skill-name">PWA</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/webpush.svg" alt="Web Push" class="imgskills" loading="lazy"><span class="skill-name">Web Push</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/capacitor.svg" alt="Capacitor" class="imgskills" loading="lazy"><span class="skill-name">Capacitor</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/chrome.svg" alt="Chrome Ext." class="imgskills" loading="lazy"><span class="skill-name">Chrome Ext.</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/figma.svg" alt="Figma" class="imgskills" loading="lazy"><span class="skill-name">Figma</span></div>
                </div>
                <div id="backend-content" class="row text-center hidden">
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/nodejs.svg" alt="Node.js" class="imgskills" loading="lazy"><span class="skill-name">Node.js</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/express.svg" alt="Express" class="imgskills" loading="lazy"><span class="skill-name">Express</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/hono.svg" alt="Hono" class="imgskills" loading="lazy"><span class="skill-name">Hono</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/fastapi.svg" alt="FastAPI" class="imgskills" loading="lazy"><span class="skill-name">FastAPI</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/flask.svg" alt="Flask" class="imgskills" loading="lazy"><span class="skill-name">Flask</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/cloudflareworkers.svg" alt="CF Workers" class="imgskills" loading="lazy"><span class="skill-name">CF Workers</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/socketio.svg" alt="Socket.IO" class="imgskills" loading="lazy"><span class="skill-name">Socket.IO</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/sse.svg" alt="SSE" class="imgskills" loading="lazy"><span class="skill-name">SSE</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/zod.svg" alt="Zod" class="imgskills" loading="lazy"><span class="skill-name">Zod</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/jwt.svg" alt="JWT" class="imgskills" loading="lazy"><span class="skill-name">JWT</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/betterauth.svg" alt="Better Auth" class="imgskills" loading="lazy"><span class="skill-name">Better Auth</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/google.svg" alt="Google OAuth" class="imgskills" loading="lazy"><span class="skill-name">Google OAuth</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/telegram.svg" alt="Telegram Bot" class="imgskills" loading="lazy"><span class="skill-name">Telegram Bot</span></div>
                </div>
                <div id="data-content" class="row text-center hidden">
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/postgresql.svg" alt="PostgreSQL" class="imgskills" loading="lazy"><span class="skill-name">PostgreSQL</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/sqlite.svg" alt="SQLite" class="imgskills" loading="lazy"><span class="skill-name">SQLite</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/sequelize.svg" alt="Sequelize" class="imgskills" loading="lazy"><span class="skill-name">Sequelize</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/drizzle.svg" alt="Drizzle ORM" class="imgskills" loading="lazy"><span class="skill-name">Drizzle ORM</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/sqlalchemy.svg" alt="SQLAlchemy" class="imgskills" loading="lazy"><span class="skill-name">SQLAlchemy</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/supabase.svg" alt="Supabase" class="imgskills" loading="lazy"><span class="skill-name">Supabase</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/dynamodb.svg" alt="DynamoDB" class="imgskills" loading="lazy"><span class="skill-name">DynamoDB</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/webassembly.svg" alt="sql.js (Wasm)" class="imgskills" loading="lazy"><span class="skill-name">sql.js (Wasm)</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/googlesheets.svg" alt="Google Sheets" class="imgskills" loading="lazy"><span class="skill-name">Google Sheets</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/pandas.svg" alt="pandas" class="imgskills" loading="lazy"><span class="skill-name">pandas</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/matplotlib.svg" alt="Matplotlib" class="imgskills" loading="lazy"><span class="skill-name">Matplotlib</span></div>
                </div>
                <div id="infra-content" class="row text-center hidden">
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/docker.svg" alt="Docker" class="imgskills" loading="lazy"><span class="skill-name">Docker</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/aws.svg" alt="AWS" class="imgskills" loading="lazy"><span class="skill-name">AWS</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/cloudflarepages.svg" alt="CF Pages" class="imgskills" loading="lazy"><span class="skill-name">CF Pages</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/nginx.svg" alt="NGINX" class="imgskills" loading="lazy"><span class="skill-name">NGINX</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/ubuntu.svg" alt="Ubuntu" class="imgskills" loading="lazy"><span class="skill-name">Ubuntu</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/pm2.svg" alt="PM2" class="imgskills" loading="lazy"><span class="skill-name">PM2</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/githubactions.svg" alt="GitHub Actions" class="imgskills" loading="lazy"><span class="skill-name">GitHub Actions</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/playwright.svg" alt="Playwright" class="imgskills" loading="lazy"><span class="skill-name">Playwright</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/googleanalytics.svg" alt="Google Analytics" class="imgskills" loading="lazy"><span class="skill-name">Google Analytics</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/git.svg" alt="Git" class="imgskills" loading="lazy"><span class="skill-name">Git</span></div>
                </div>
                <div id="aiml-content" class="row text-center hidden">
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/numpy.svg" alt="NumPy" class="imgskills" loading="lazy"><span class="skill-name">NumPy</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/tensorflow.svg" alt="TensorFlow" class="imgskills" loading="lazy"><span class="skill-name">TensorFlow</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/keras.svg" alt="Keras" class="imgskills" loading="lazy"><span class="skill-name">Keras</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/scikit-learn.svg" alt="scikit-learn" class="imgskills" loading="lazy"><span class="skill-name">scikit-learn</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/opencv.svg" alt="OpenCV" class="imgskills" loading="lazy"><span class="skill-name">OpenCV</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/mediapipe.svg" alt="MediaPipe" class="imgskills" loading="lazy"><span class="skill-name">MediaPipe</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/huggingface.svg" alt="Hugging Face" class="imgskills" loading="lazy"><span class="skill-name">Hugging Face</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/gradio.svg" alt="Gradio" class="imgskills" loading="lazy"><span class="skill-name">Gradio</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/ollama.svg" alt="Ollama" class="imgskills" loading="lazy"><span class="skill-name">Ollama</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/gemini.svg" alt="Gemini API" class="imgskills" loading="lazy"><span class="skill-name">Gemini API</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/claude.svg" alt="Claude API" class="imgskills" loading="lazy"><span class="skill-name">Claude API</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/jupyter.svg" alt="Jupyter" class="imgskills" loading="lazy"><span class="skill-name">Jupyter</span></div>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
<div class="text-center text-silent text14">
    &#169; MUHAMMAD RAFI ARSYA
</div>
<br>
