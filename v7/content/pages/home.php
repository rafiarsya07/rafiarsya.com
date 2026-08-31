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
            Science Society of the Faculty of Computer Science &amp; IT, and
            <span class="marksalmon">Head of Website Division</span> in the Data &amp; Information System Bureau at
            PPI Malaysia, where I own the association's official website end to end.
        </p>

        <p class="about-section">
            Most of what I build is self-hosted and runs without a cloud bill. Recently that has meant
            <span class="highlightv1">PaperMind</span>, a RAG paper analyzer running a local LLM with zero external
            API calls; <span class="highlightv1">ThoughtLog</span>, a full-stack blog with a CMS written from
            scratch on Node, Express and PostgreSQL; and
            <span class="highlightv1">snip</span>, a serverless URL shortener defined as infrastructure-as-code on
            AWS Lambda and DynamoDB. On the ML side I work with
            <span class="marksalmon">TensorFlow, PyTorch and OpenCV</span>, and on the web with
            <span class="marksalmon">React, Next.js and Node</span>.
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
            <div class="col-6 col-sm-5 col-lg-4 col-xl-3" style="margin-left: -15px;">
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

        <div class="about-section">
            <p class="text-silent">Education</p>
            <div class="d-flex flex-wrap justify-content-between">
                <div class="d-flex flex-wrap gap-2">
                    <img src="icon/UM.png" alt="UM" class="education-image" />
                    <div>
                        <p><b>Bachelor of Computer Science</b></p>
                        <a class="d-flex align-items-center gap-1 textlink" href="https://study.um.edu.my/"
                            target="_blank">University of Malaya, Malaysia<arrow-icon class="togo-icon"
                                style="margin-top: -1px;"></arrow-icon></a>
                    </div>
                </div>
                <p class="text-silent">Since 2025</p>
            </div>
            Bachelor of Computer Science with a <span class="markblue">Software Engineering</span> specialization,
            focused on <span class="highlightv1">full-stack development</span> and applied problem-solving.
        </div>
        <br>

        <div class="about-section">
            <p class="text-silent">Experience</p>
            <div class="d-flex flex-wrap justify-content-between">
                <div class="d-flex flex-wrap gap-2">
                    <img src="icon/pekom.png" alt="PEKOM" class="education-image" />
                    <div>
                        <p><b>Technical Executive Committee</b></p>
                        <a class="d-flex align-items-center gap-1 textlink" href="https://www.fsktm.um.edu.my/"
                            target="_blank">PEKOM, Computer Science Society of Universiti Malaya<arrow-icon
                                class="togo-icon" style="margin-top: -1px;"></arrow-icon></a>
                    </div>
                </div>
                <p class="text-silent">Since 2026</p>
            </div>
            Serving in the Website Division of PEKOM, the student society of the Faculty of Computer Science &amp;
            IT. I help <span class="highlightv1">build and maintain the society's web platforms</span> and
            support faculty-wide events.
        </div>

        <div class="about-section">
            <div class="d-flex flex-wrap justify-content-between">
                <div class="d-flex flex-wrap gap-2">
                    <img src="icon/ppim.png" alt="PPI Malaysia" class="education-image" />
                    <div>
                        <p><b>Head of Website Division, Data &amp; Information System Bureau</b></p>
                        <a class="d-flex align-items-center gap-1 textlink" href="https://ppimalaysia.id"
                            target="_blank">PPI Malaysia (Indonesian Students Association)<arrow-icon
                                class="togo-icon" style="margin-top: -1px;"></arrow-icon></a>
                    </div>
                </div>
                <p class="text-silent">Since 2025</p>
            </div>
            Leading the Website Division with <span class="markblue">full ownership of the official PPI Malaysia
                website</span>: development, maintenance, and continuous improvement for Indonesian students
            across Malaysia.
        </div>

        <div class="about-section">
            <div class="d-flex flex-wrap justify-content-between">
                <div class="d-flex flex-wrap gap-2">
                    <img src="icon/ppium.png" alt="PPI UM" class="education-image" />
                    <div>
                        <p><b>Head of Department, Art Exhibition at IDFEST</b></p>
                        <a class="d-flex align-items-center gap-1 textlink" href="https://ppiunimalaya.id"
                            target="_blank">PPI University of Malaya<arrow-icon class="togo-icon"
                                style="margin-top: -1px;"></arrow-icon></a>
                    </div>
                </div>
                <p class="text-silent">Since 2026</p>
            </div>
            Directing the Art Exhibition division for IDFEST, an international event showcasing Indonesian heritage
            at Universiti Malaya, from concept and curation through to delivery.
        </div>

        <div class="about-section">
            <div class="d-flex flex-wrap justify-content-between">
                <div class="d-flex flex-wrap gap-2">
                    <img src="icon/ppium.png" alt="IDFEST" class="education-image" />
                    <div>
                        <p><b>Website Development Committee at IDFEST</b></p>
                        <a class="d-flex align-items-center gap-1 textlink" href="https://idfest.ppiunimalaya.id"
                            target="_blank">IDFEST 2026<arrow-icon class="togo-icon"
                                style="margin-top: -1px;"></arrow-icon></a>
                    </div>
                </div>
                <p class="text-silent">Since Jun 2026</p>
            </div>
            Building the official IDFEST website with <span class="marksalmon">Next.js and Tailwind CSS</span>,
            responsive, interactive interfaces translated from Figma into production-ready pages.
        </div>
        <br>

        <div class="about-section">
            <p class="text-silent">Volunteering</p>
            <div class="d-flex flex-wrap justify-content-between">
                <div class="d-flex flex-wrap gap-2">
                    <img src="icon/ppim.png" alt="PPI Malaysia" class="education-image" />
                    <div>
                        <p><b>LARAS: Transportation Team &amp; Field Committee</b></p>
                        <a class="d-flex align-items-center gap-1 textlink" href="https://ppimalaysia.id"
                            target="_blank">PPI Malaysia<arrow-icon class="togo-icon"
                                style="margin-top: -1px;"></arrow-icon></a>
                    </div>
                </div>
                <p class="text-silent m0">2026</p>
            </div>
            Volunteered on the Transportation Team and Field Committee for LARAS, covering logistics, on-ground
            coordination, and event-day operations.
        </div>
        <br>

        <div class="about-section">
            <div class="d-flex flex-wrap justify-content-between">
                <div class="d-flex flex-wrap gap-2">
                    <img src="icon/chula.png" alt="Chulalongkorn University" class="education-image" />
                    <div>
                        <p><b>Chulalongkorn University, Bangkok</b></p>
                        <span class="text-silent">Organising Committee &amp; Documentation</span>
                    </div>
                </div>
            </div>
            One of a <span class="markblue">four-person committee</span> running a five-day programme at
            Chulalongkorn University, Thailand's top-ranked university, and the sole documentation photographer
            covering sessions and daily activities across all five days.
        </div>
        <br>

        <div class="about-section">
            <div class="text-silent">Skills</div>
            <div class="horizontal">
                <a class="menu-item active" id="frontend"><span>Front End</span></a>
                <a class="menu-item" id="backend"><span>Back End</span></a>
                <a class="menu-item" id="aiml"><span>AI / ML</span></a>
                <a class="menu-item" id="devops"><span>DevOps</span></a>
                <a class="menu-item" id="software"><span>Software</span></a>
            </div>
            <hr>
            <div class="menu-item-content">
                <div id="frontend-content" class="row text-center">
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/typescript.svg" alt="TypeScript" class="imgskills" loading="lazy"><span class="skill-name">TypeScript</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/javascript.svg" alt="JavaScript" class="imgskills" loading="lazy"><span class="skill-name">JavaScript</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/react.svg" alt="React" class="imgskills" loading="lazy"><span class="skill-name">React</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/nextjs.svg" alt="Next.js" class="imgskills" loading="lazy"><span class="skill-name">Next.js</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/tailwind.svg" alt="Tailwind" class="imgskills" loading="lazy"><span class="skill-name">Tailwind</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/html.svg" alt="HTML5" class="imgskills" loading="lazy"><span class="skill-name">HTML5</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/css.svg" alt="CSS3" class="imgskills" loading="lazy"><span class="skill-name">CSS3</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/bootstrap.svg" alt="Bootstrap" class="imgskills" loading="lazy"><span class="skill-name">Bootstrap</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/vite.svg" alt="Vite" class="imgskills" loading="lazy"><span class="skill-name">Vite</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/framer.svg" alt="Framer Motion" class="imgskills" loading="lazy"><span class="skill-name">Framer Motion</span></div>
                </div>
                <div id="backend-content" class="row text-center hidden">
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/nodejs.svg" alt="Node.js" class="imgskills" loading="lazy"><span class="skill-name">Node.js</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/express.svg" alt="Express" class="imgskills" loading="lazy"><span class="skill-name">Express</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/python.svg" alt="Python" class="imgskills" loading="lazy"><span class="skill-name">Python</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/java.svg" alt="Java" class="imgskills" loading="lazy"><span class="skill-name">Java</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/postgresql.svg" alt="PostgreSQL" class="imgskills" loading="lazy"><span class="skill-name">PostgreSQL</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/mysql.svg" alt="MySQL" class="imgskills" loading="lazy"><span class="skill-name">MySQL</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/redis.svg" alt="Redis" class="imgskills" loading="lazy"><span class="skill-name">Redis</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/socketio.svg" alt="Socket.IO" class="imgskills" loading="lazy"><span class="skill-name">Socket.IO</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/fastapi.svg" alt="FastAPI" class="imgskills" loading="lazy"><span class="skill-name">FastAPI</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/php.svg" alt="PHP" class="imgskills" loading="lazy"><span class="skill-name">PHP</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/flask.svg" alt="Flask" class="imgskills" loading="lazy"><span class="skill-name">Flask</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/sqlite.svg" alt="SQLite" class="imgskills" loading="lazy"><span class="skill-name">SQLite</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/supabase.svg" alt="Supabase" class="imgskills" loading="lazy"><span class="skill-name">Supabase</span></div>
                </div>
                <div id="aiml-content" class="row text-center hidden">
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/tensorflow.svg" alt="TensorFlow" class="imgskills" loading="lazy"><span class="skill-name">TensorFlow</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/keras.svg" alt="Keras" class="imgskills" loading="lazy"><span class="skill-name">Keras</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/pytorch.svg" alt="PyTorch" class="imgskills" loading="lazy"><span class="skill-name">PyTorch</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/numpy.svg" alt="NumPy" class="imgskills" loading="lazy"><span class="skill-name">NumPy</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/opencv.svg" alt="OpenCV" class="imgskills" loading="lazy"><span class="skill-name">OpenCV</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/scikit-learn.svg" alt="scikit-learn" class="imgskills" loading="lazy"><span class="skill-name">scikit-learn</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/pandas.svg" alt="pandas" class="imgskills" loading="lazy"><span class="skill-name">pandas</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/matplotlib.svg" alt="Matplotlib" class="imgskills" loading="lazy"><span class="skill-name">Matplotlib</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/streamlit.svg" alt="Streamlit" class="imgskills" loading="lazy"><span class="skill-name">Streamlit</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/jupyter.svg" alt="Jupyter" class="imgskills" loading="lazy"><span class="skill-name">Jupyter</span></div>
                </div>
                <div id="devops-content" class="row text-center hidden">
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/aws.svg" alt="AWS" class="imgskills" loading="lazy"><span class="skill-name">AWS</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/docker.svg" alt="Docker" class="imgskills" loading="lazy"><span class="skill-name">Docker</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/nginx.svg" alt="NGINX" class="imgskills" loading="lazy"><span class="skill-name">NGINX</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/bash.svg" alt="Bash" class="imgskills" loading="lazy"><span class="skill-name">Bash</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/git.svg" alt="Git" class="imgskills" loading="lazy"><span class="skill-name">Git</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/ubuntu.svg" alt="Ubuntu" class="imgskills" loading="lazy"><span class="skill-name">Ubuntu</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/cloudflare.svg" alt="Cloudflare" class="imgskills" loading="lazy"><span class="skill-name">Cloudflare</span></div>
                </div>
                <div id="software-content" class="row text-center hidden">
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/vscode.svg" alt="VS Code" class="imgskills" loading="lazy"><span class="skill-name">VS Code</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/figma.svg" alt="Figma" class="imgskills" loading="lazy"><span class="skill-name">Figma</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/canva.svg" alt="Canva" class="imgskills" loading="lazy"><span class="skill-name">Canva</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/latex.svg" alt="LaTeX" class="imgskills" loading="lazy"><span class="skill-name">LaTeX</span></div>
                        <div class="col-md-2 col-3 skill-cell"><img src="skills/kaggle.svg" alt="Kaggle" class="imgskills" loading="lazy"><span class="skill-name">Kaggle</span></div>
                </div>
            </div>
        </div>
        <br>
    </div>
</div>
<div class="text-center text-silent text14">
    &#169; <script>document.write(new Date().getFullYear())</script> MUHAMMAD RAFI ARSYA
</div>
<br>
