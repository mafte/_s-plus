<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package _s_plus
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 */

get_header();
?>

<main id="main-content" class="site-main">

	<div class="container">
		<div class="row">
			<div class="col-12">

				<style>
					.box-color {
						--size: 50px;
						width: var(--size);
						height: var(--size);
						display: inline-flex;
					}

					.ex-title {
						border-bottom: 1px solid;
						margin-bottom: 1rem;
						margin-top: 3rem;
					}

					.ex-sub-title {
						margin: 1rem 0 2rem;
						font-weight: 400;
					}

					.mb-05 {
						margin-bottom: 0.5rem;
					}
				</style>

				<h2 class="ex-title">Buttons</h2>
				<h3 class="ex-sub-title">Primary</h3>

				<a href="#" class="btn btn--primary mb-05">Button primary</a>
				<a href="#" class="btn btn--primary btn--outline mb-05">Button primary outline</a>

				<h3 class="ex-sub-title">Secondary</h3>
				<a href="#" class="btn btn--secondary mb-05">Button secondary</a>
				<a href="#" class="btn btn--secondary btn--outline mb-05">Button secondary outline</a>

				<h3 class="ex-sub-title">Links</h3>
				<a href="#" class="">Hyperlink</a>

				<h2 class="ex-title">Global Colors</h2>

				<h3 class="ex-sub-title">Primary</h3>
				<div class="box-color" style="background: var(--c-primary);"></div>
				<div class="box-color" style="background: var(--c-primary-dark);"></div>
				<div class="box-color" style="background: var(--c-primary-light);"></div>

				<h3 class="ex-sub-title">Secondary</h3>
				<div class="box-color" style="background: var(--c-secondary);"></div>
				<div class="box-color" style="background: var(--c-secondary-dark);"></div>
				<div class="box-color" style="background: var(--c-secondary-light);"></div>

				<h3 class="ex-sub-title">Accent</h3>
				<div class="box-color" style="background: var(--c-accent);"></div>
				<div class="box-color" style="background: var(--c-accent-dark);"></div>
				<div class="box-color" style="background: var(--c-accent-light);"></div>

				<h2 class="ex-title">Global Fonts</h2>

				<h3 class="ex-sub-title" style="font-family: var(--ff-primary); font-weight:700">Primary</h3>
				<p style="font-family: var(--ff-primary);    font-size: var(--fs-3);">Everyone has the right to an effective remedy by the competent national tribunals for acts violating the fundamental rights granted him by the constitution or by law.</p>

				<h3 class="ex-sub-title">Secondary</h3>
				<p style="font-family: var(--ff-secondary);    font-size: var(--fs-3);">Everyone has the right to an effective remedy by the competent national tribunals for acts violating the fundamental rights granted him by the constitution or by law.</p>

				<h3 class="ex-sub-title">Font Size Body</h3>
				<p style="font-family: var(--body-font-size); ">Everyone has the right to an effective remedy by the competent national tribunals for acts violating the fundamental rights granted him by the constitution or by law. Everyone has the right to an effective remedy by the competent national tribunals for acts violating the fundamental rights granted him by the constitution or by law. Everyone has the right to an effective remedy by the competent national tribunals for acts violating the fundamental rights granted him by the constitution or by law.</p>


				<h2 class="ex-title">Responsives font-sizes</h2>
				<p style="font-size: var(--fs-1)">fs-1: Whereas a common understanding of these rights and freedoms is</p>
				<p style="font-size: var(--fs-2)">fs-2: Whereas a common understanding of these rights and freedoms is</p>
				<p style="font-size: var(--fs-3)">fs-3: Whereas a common understanding of these rights and freedoms is</p>
				<p style="font-size: var(--fs-4)">fs-4: Whereas a common understanding of these rights and freedoms is</p>
				<p style="font-size: var(--fs-5)">fs-5: Whereas a common understanding of these rights and freedoms is</p>
				<p style="font-size: var(--fs-6)">fs-6: Whereas a common understanding of these rights and freedoms is</p>
				<p style="font-size: var(--fs-hero)">fs-hero: Whereas a common understanding of these rights and freedoms is</p>

				<h1 style="font-size: var(--fs-1)">fs-1: Whereas a common understanding of these rights and freedoms is</h1>
				<h1 style="font-size: var(--fs-2)">fs-2: Whereas a common understanding of these rights and freedoms is</h1>
				<h1 style="font-size: var(--fs-3)">fs-3: Whereas a common understanding of these rights and freedoms is</h1>
				<h1 style="font-size: var(--fs-4)">fs-4: Whereas a common understanding of these rights and freedoms is</h1>
				<h1 style="font-size: var(--fs-5)">fs-5: Whereas a common understanding of these rights and freedoms is</h1>
				<h1 style="font-size: var(--fs-6)">fs-6: Whereas a common understanding of these rights and freedoms is</h1>
				<h1 style="font-size: var(--fs-hero)">fs-hero: Whereas a common understanding of these rights and freedoms is</h1>

				<h2 class="ex-title">Form elements</h2>


				<section id="form">
					<form>
						<!-- Search -->
						<label for="search">Search</label>
						<input type="search" id="search" name="search" placeholder="Search" class="">

						<!-- Text -->
						<label for="text">Text</label>
						<input type="text" id="text" name="text" placeholder="Text" class="">
						<small>Curabitur consequat lacus at lacus porta finibus.</small>

						<!-- Select -->
						<label for="select">Select</label>
						<select id="select" name="select" required="" class="">
							<option value="" selected="">Select…</option>
							<option>…</option>
						</select>

						<!-- File browser -->
						<label for="file">File browser
							<input type="file" id="file" name="file">
						</label>

						<!-- Range slider control -->
						<label for="range">Range slider
							<input type="range" min="0" max="100" value="50" id="range" name="range">
						</label>

						<!-- States -->
						<div class="grid">
							<label for="valid">
								Valid
								<input type="text" id="valid" name="valid" placeholder="Valid" aria-invalid="false" class="">
							</label>
							<label for="invalid">
								Invalid
								<input type="text" id="invalid" name="invalid" placeholder="Invalid" aria-invalid="true" class="">
							</label>
							<label for="disabled">
								Disabled
								<input type="text" id="disabled" name="disabled" placeholder="Disabled" disabled="">
							</label>
						</div>

						<div class="grid">

							<!-- Date-->
							<label for="date">Date
								<input type="date" id="date" name="date" class="">
							</label>

							<!-- Time-->
							<label for="time">Time
								<input type="time" id="time" name="time" class="">
							</label>

							<!-- Color-->
							<label for="color">Color
								<input type="color" id="color" name="color" value="#0eaaaa">
							</label>

						</div>

						<div class="grid">

							<!-- Checkboxes -->
							<fieldset>
								<legend><strong>Checkboxes</strong></legend>
								<label for="checkbox-1">
									<input type="checkbox" id="checkbox-1" name="checkbox-1" checked="">
									Checkbox
								</label>
								<label for="checkbox-2">
									<input type="checkbox" id="checkbox-2" name="checkbox-2">
									Checkbox
								</label>
							</fieldset>

							<!-- Radio buttons -->
							<fieldset>
								<legend><strong>Radio buttons</strong></legend>
								<label for="radio-1">
									<input type="radio" id="radio-1" name="radio" value="radio-1" checked="">
									Radio button
								</label>
								<label for="radio-2">
									<input type="radio" id="radio-2" name="radio" value="radio-2">
									Radio button
								</label>
							</fieldset>

							<!-- Switch -->
							<fieldset>
								<legend><strong>Switches</strong></legend>
								<label for="switch-1">
									<input type="checkbox" id="switch-1" name="switch-1" role="switch" checked="">
									Switch
								</label>
								<label for="switch-2">
									<input type="checkbox" id="switch-2" name="switch-2" role="switch">
									Switch
								</label>
							</fieldset>

						</div>

						<!-- Buttons -->
						<input type="reset" value="Reset" onclick="event.preventDefault()">
						<input type="submit" value="Submit" onclick="event.preventDefault()">

					</form>
				</section>
			</div>
		</div>
	</div>

</main><!-- #main -->

<?php

get_footer();
