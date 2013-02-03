<style type="text/css">
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
</style>
<div class="wrap">
	<h2>Add Issue</h2>
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
			<input type="submit"/>
		</div>
	</form>
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
			// 	$error = new WP_Error('no_issue_cover', "Couldn't find a cover post for issue {$issue->name}");
			// 	print($error->get_error_message());
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
				$editPostAnchor = '<em>Create Issue Cover</em>';
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
</div>
