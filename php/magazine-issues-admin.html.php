<style type="text/css">
section {
    margin-bottom: 3em;
}
.form-control {
    margin: 1em 0 1em 0;
}
.existing-issues {
    border-spacing: 2em 0.5em;
}
.existing-issues td {
    /*border: 1px solid #999;*/
}
.error {
    color: red;
    font-weight: bold;
}
.success {
    color: green;
    font-weight: bold;
}
</style>
<div class="wrap">
    <?php
    /*
    <p>TODO: Select current issue: Changes the Appearance/Menu option</p>
    <ul><li>http://www.new.poetrynw.org/wp-admin/nav-menus.php</li>
        <li>http://codex.wordpress.org/Function_Reference/wp_nav_menu</li>
        <li>http://codex.wordpress.org/Function_Reference/wp_get_nav_menu_items</li>
    </ul>
    */ ?>
    <section>
        <h2>New Issue</h2>
        <form method="POST" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
            <div class="form-control">
                <h3><label for="magazineIssueTitle">Issue Cover Title</label></h3>
                <p class="help">This is the headline of the Issue Cover.</p>
                <input type="text" name="magazineIssueTitle" />
            </div>
            <div class="form-control">
                <h3><label for="magazineIssueTerm">Issue Tag</label></h3>
                <p class="help">This is the name of the "tag" that each post in the issue should be filed under; e.g. Winter 2012-2013</p>
                <input type="text" name="magazineIssueTerm" />
            </div>
            <div class="form-control">
                <input type="submit" value="Create Issue"/>
            </div>
        </form>
    </section>

    <section>
        <h2>Existing Issues</h2>
        <table class="existing-issues">
            <tr><th>Cover Title</th><th>Issue Tag</th></tr>
        <?php
            // Print out edit links to existing issue posts and terms
            $issues = get_terms('issue', array(
                'orderby'=>'id',
                'order' => 'DESC',
                'hide_empty' => false));
            // dump($issues);
            foreach($issues as $issue) {
                // dump($issue);
                $postArgs = array(
                    'post_type' => 'issue_cover',
                    'post_status' => array('publish', 'draft', 'pending'),
                    'tax_query' => array(array(
                        'taxonomy' => 'issue',
                        'field' => 'slug',
                        'terms' => $issue->slug,
                        'operator' => 'IN'
                    ))
                );
                $posts = get_posts($postArgs);
                // if (count($posts) !== 1) {
                //  $error = new WP_Error('no_issue_cover', "Couldn't find a cover post for issue {$issue->name}");
                //  print($error->get_error_message());
                // }
                $post = $posts[0];
                if ($post) {
                    // dump($post);
                    $unPublished = '';
                    if ($post->post_status !== 'publish') {
                        $unPublished = ' <em>(not published)</em>';
                    }
                    $postTitle = $post->post_title;
                    $editPostPath = 'post.php?post=' . $post->ID . '&action=edit';
                    $editPostAnchor = '<a title="Edit Issue Cover" href="' . admin_url($editPostPath) . '">' . $postTitle . '</a>' . $unPublished;
                } else {
                    $postTitle = 'No Issue Cover found';
                    $newPostPath = 'post-new.php?post_type=issue_cover';
                    $editPostAnchor = '<em><a href="' . admin_url($newPostPath) . '">Create Issue Cover</a></em>';
                }
                // dump($posts);
                $editTermPath = 'edit-tags.php?action=edit&taxonomy=issue&tag_ID=' . $issue->term_id;
                $editTermAnchor = '<a title="Edit Issue Tag" href="' . admin_url($editTermPath) . '">' . $issue->name . '</a>';
                print('<tr>');
                print('<td>' . $editPostAnchor . '</td>');
                print('<td>' . $editTermAnchor . '</td>');
                print('</tr>');
            }
        ?>
        </table>
    </section>

    <section>
        <h2>Current Issue</h2>
        <form method="POST" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                <p>Change which issue the "Current Issue" menu item links to.</p>
                <div class="form-control">
                    <select name="currentMagazineIssue">
                        <option value="1">Issue 1</option>
                        <option value="2">Issue 2</option>
                        <option value="3">Issue 3</option>
                    </select>
                </div>
                <div class="form-control">
                    <button onclick="javascript:return false;">Change Current Issue</button>
                    <!--<input type="submit" value="Change Current Issue"/> -->
                </div>
        </form>
    </section>
</div>
