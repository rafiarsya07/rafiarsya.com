/* =========================================================
   console.js, the sample-query console on the Steam Market
   Intelligence page. Ported from the v4 write-up: the result
   sets are the real output of each query against
   steam_games.db, so the walkthrough matches the live tool.
   Exposed as consolefunc() so the app shell can re-run it
   after the page is swapped in.
   ========================================================= */
function consolefunc() {
    if (!document.getElementById('console-run')) return;

    var queries = {
        top: {
            sql: 'SELECT name, developer, positive_ratings, negative_ratings,\n       ROUND(1.0*positive_ratings/(positive_ratings+negative_ratings), 3) AS rating\nFROM games_deduped\nWHERE (positive_ratings+negative_ratings) >= 100\nORDER BY rating DESC\nLIMIT 5;',
            cols: ['name', 'developer', 'positive_ratings', 'negative_ratings', 'rating'],
            rows: [
                ['Hollow Odyssey', 'Obsidian Lantern', 1163, 12, 0.99],
                ['Iron Realm', 'Velvet Circuit', 611, 7, 0.989],
                ['Frozen Legacy: Horizon', 'NeonByte', 461, 5, 0.989],
                ['Iron Citadel: Nexus', 'Driftwood Interactive', 719, 8, 0.989],
                ['Hollow Throne: Throne', 'Frostbyte Collective', 174, 2, 0.989]
            ],
            ms: 14
        },
        genre: {
            sql: 'SELECT g.genre_name, COUNT(*) AS games, ROUND(AVG(d.price),2) AS avg_price\nFROM games_deduped d\nJOIN game_genres g ON g.app_id = d.app_id\nGROUP BY g.genre_name\nORDER BY avg_price DESC\nLIMIT 5;',
            cols: ['genre_name', 'games', 'avg_price'],
            rows: [
                ['Sandbox', 154, 15.37],
                ['Indie', 173, 14.53],
                ['Action', 155, 14.12],
                ['Visual Novel', 170, 13.6],
                ['Shooter', 144, 13.59]
            ],
            ms: 19
        },
        year: {
            sql: "SELECT strftime('%Y', release_date) AS yr, COUNT(*) AS releases\nFROM games_deduped\nGROUP BY yr\nORDER BY yr\nLIMIT 5;",
            cols: ['yr', 'releases'],
            rows: [
                ['2008', 87], ['2009', 69], ['2010', 85], ['2011', 84], ['2012', 72]
            ],
            ms: 8
        },
        rank: {
            sql: 'WITH ranked AS (\n  SELECT g.genre_name, d.name,\n         RANK() OVER (PARTITION BY g.genre_name ORDER BY d.positive_ratings DESC) AS rnk\n  FROM games_deduped d\n  JOIN game_genres g ON g.app_id = d.app_id\n)\nSELECT * FROM ranked WHERE rnk <= 3\nORDER BY genre_name, rnk\nLIMIT 6;',
            cols: ['genre_name', 'name', 'rnk'],
            rows: [
                ['Action', 'Neon Throne: Horizon', 1],
                ['Action', 'Hollow Legacy', 2],
                ['Action', 'Eternal Throne: Citadel', 3],
                ['Adventure', 'Neon Frontier: Kingdom', 1],
                ['Adventure', 'Crimson Citadel: Throne', 2],
                ['Adventure', 'Drifting Kingdom: Odyssey', 3]
            ],
            ms: 27
        },
        schema: {
            sql: "SELECT name, type FROM sqlite_master\nWHERE type IN ('table','view');",
            cols: ['name', 'type'],
            rows: [
                ['genres', 'table'], ['games', 'table'], ['game_genres', 'table'], ['games_deduped', 'view']
            ],
            ms: 2
        }
    };
    var sqlEl = document.getElementById('console-sql');
    var runBtn = document.getElementById('console-run');
    var metaEl = document.getElementById('console-meta');
    var tableEl = document.getElementById('console-table');
    var currentQ = 'top';
    if (!sqlEl || !runBtn) return;

    function resetResult() {
        metaEl.textContent = 'Click Run query to execute';
        metaEl.classList.remove('done');
        tableEl.querySelector('thead').innerHTML = '';
        tableEl.querySelector('tbody').innerHTML = '';
    }

    document.querySelectorAll('.p-console-tab').forEach(function(tab) {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.p-console-tab').forEach(function(t) { t.classList.remove('active'); });
            tab.classList.add('active');
            currentQ = tab.dataset.q;
            sqlEl.textContent = queries[currentQ].sql;
            resetResult();
        });
    });

    runBtn.addEventListener('click', function() {
        var q = queries[currentQ];
        runBtn.classList.add('running');
        metaEl.classList.remove('done');
        metaEl.textContent = 'Running…';
        tableEl.querySelector('thead').innerHTML = '';
        tableEl.querySelector('tbody').innerHTML = '';
        setTimeout(function() {
            var thead = tableEl.querySelector('thead');
            var tbody = tableEl.querySelector('tbody');
            var headRow = document.createElement('tr');
            q.cols.forEach(function(c) {
                var th = document.createElement('th');
                th.textContent = c;
                headRow.appendChild(th);
            });
            thead.appendChild(headRow);
            q.rows.forEach(function(row) {
                var tr = document.createElement('tr');
                row.forEach(function(val, i) {
                    var td = document.createElement('td');
                    td.textContent = val;
                    if (typeof val === 'number') td.classList.add('num');
                    tr.appendChild(td);
                });
                tbody.appendChild(tr);
            });
            metaEl.textContent = q.rows.length + ' rows returned in ' + q.ms + 'ms';
            metaEl.classList.add('done');
            runBtn.classList.remove('running');
        }, 380);
    });
}
