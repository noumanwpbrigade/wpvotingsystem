<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package votingsystem
 */
ob_start();
get_header();
?>

	<main id="primary" class="site-main">
		<div class="container">
			<div style="height: 40px"></div> <!-- spacer -->


			
			
		<div style="height: 40px"></div> <!-- spacer -->
		<table>
            <thead>
                <th>Name</th>
                <th>Part Name</th>
                <th>Image</th>
                <th>Votes Received</th>
            </thead>
            <tbody>
           <?php
            $candidates = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}candidates" );
            $counter = 0;

            foreach ( $candidates as $candidate ) {
                // Display candidate information
                $counter++;

                echo "<tr>
                        <td>{$candidate->candidate_name}</td>
                        <td>{$candidate->partyname}</td>
                        <td><img src='{$candidate->entakhabineshan	}' alt='Entakhabi Neshan' width='50px' height='50px'></td>
                        <td>{$candidate->votesReceived}</td>
                    </tr>";
            }
            ?>
           </tbody>
           
           
        </table>
		</div>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();





