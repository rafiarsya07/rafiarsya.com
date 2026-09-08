<div class="row" style="overflow: hidden !important; height: 99vh; width: 100%;">
    <div class="blog-navbar">
        <div class="sticky-top d-flex align-items-center" style="padding-left: 15px; padding-right: 5px;">
            <div class="d-flex justify-content-between align-items-center" style="width: 100%;">
                <div class="d-flex align-items-center" style="margin-top: -3px; margin-left: -10px;">
                    <div class="burger-icon">
                        <button type="button" class="btn btn-main d-flex justify-content-between align-items-center"
                            onclick="burgerToogle()">
                            <menu-icon class="burger-icon-data"></menu-icon>
                        </button>
                    </div>
                    <span style="margin-left: 10px;"><b>Blog</b></span>
                </div>
                <a href="https://blog.rafiarsya.com" target="_blank" rel="noopener"
                    class="btn btn-main d-flex align-items-center button-border" style="height: 30px;">
                    <span class="menu-icon"><stream-icon class="menu-icon-data"></stream-icon></span>
                    <span style="margin-top: -2px;">Full blog</span>
                </a>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="blog-list" style="width: 100%; max-width: 600px;">
                <?php
                $blogfile = __DIR__. '/../../data/blog.json';
                $blog = file_exists($blogfile) ? json_decode(file_get_contents($blogfile), true): [];
                foreach ($blog as $post) {
                    echo '
                <button class="btn btn-blog" id="blogmenu" onclick="blogActive(this)" data-id="'. htmlspecialchars($post['id']). '">
                    <span class="badge blog-badge '. htmlspecialchars($post['badge']). '">'. htmlspecialchars($post['category']). '</span><br>
                    '. htmlspecialchars($post['title']). '<br>
                    <span style="font-weight: lighter;">'. htmlspecialchars($post['date']). '</span>
                </button>';
                }
                ?>
            </div>
        </div>
    </div>
    <div class="col blog-container idle" id="blog-container">
        <div class="blog-empty">
            <blog-icon style="--iconsize:34px;--iconcolor:#c9ccd1"></blog-icon>
            <p style="margin-top:12px"><b>Select a post</b></p>
            <p class="text14">Pick something from the list to read it here</p>
        </div>
    </div>
</div>
