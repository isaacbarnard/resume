<style>
:root {
  --defaultBack: <?php echo $Styles['color']; ?>;
}
</style>
<div class="container">
	<div class="resume-wrapper">
		<div class="resume">
			<div class="left">
				<div>
					<div class="name">
						<h1><?php echo $Contacts['first_name'] . ' ' . $Contacts['last_name']; ?></h1>
						<hr>
						<p><?php echo $Contacts['description']; ?></p>						
					</div>
					<div class="info">
						<?php 
							foreach ($ContactInfo as $key => $value) {
								echo '<div>';
								loadSvg($key.'-icon');
								echo '<p>'.$value.'</p>';
								echo '</div>';
							}
						?>
					</div>
					<div class="skills">
						<h1>TECHNICAL SKILLS</h1>
						<hr>
						<?php 
							foreach ($TechnicalSkills as $item) {
								echo '<div class="item">';
								echo '<div>'.$item['name'].'</div>';
								$stars = 0;
								while($stars < (int) $item['value']){
									if($stars >= 5) { break; }
									echo '<div class="fill"></div>';
									$stars++;
								}
								while($stars < 5){
									echo '<div class="invis"></div>';
									$stars++;									
								}
								echo '</div>';
							}
						?>
					</div>
				</div>
			</div>
			<div class="right">
				<div class="work">
					<h1 class="indent">WORK EXPERIENCE</h1>
					<hr>
					<?php 
						foreach ($WorkExperience as $we) {
							echo '<div class="item indent">';
							echo '<h2>'.$we['job_title'].'</h2>';
							echo '<h3>'.$we['company_name'].'</h3>';
							echo '<div class="date-address">';
							echo '<div>'.$we['company_city'].', '.$we['company_province'].'</div>';
							if($we['start_year'] === $we['end_year']) {
								echo '<div>'.$we['start_year'].'</div>';
							} else {
								echo '<div>'.$we['start_year'].' - '.$we['end_year'].'</div>';
							}
							echo '</div>';
							echo '<div class="work-details">';
							foreach($WorkExperienceDetails as $wd){
								if($we['id'] === $wd['work_experience_id']) {
									echo '<div class="item">';
									echo '<div>';
									loadSvg('square-bullet');
									echo '</div>';
									echo '<div>'.$wd['description'].'</div>';
									echo '</div>';
								}
							}
							echo '</div>';
							echo '</div>';
						}
					?>			
				</div>
				<div class="education">
					<h1 class="indent">EDUCATION</h1>
					<hr>
					<?php 
						foreach ($Education as $ed) {
							echo '<div class="item indent">';
							echo '<h2>'.$ed['course_name'].'</h2>';
							echo '<h3>'.$ed['school_name'].'</h3>';
							echo '<div class="date-address">';
							echo '<div>'.$ed['school_city'].', '.$ed['school_province'].'</div>';
							if($ed['start_year'] === $ed['end_year']) {
								echo '<div>'.$ed['start_year'].'</div>';
							} else {
								echo '<div>'.$ed['start_year'].' - '.$ed['end_year'].'</div>';
							}
							echo '</div>';
							echo '</div>';
						}
					?>	
				</div>
			</div>		
		</div>	
	</div>
</div>