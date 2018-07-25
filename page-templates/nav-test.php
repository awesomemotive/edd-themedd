<?php
/**
 * Template Name: Nav test
 */

?>

<?php
	function themedd_custom_search_form() {
		?>
		<form class="form-inline my-2 my-md-0 ml-lg-3">
			<input class="form-control" placeholder="Search" type="text">
		</form>
		<?php
	}

	function themedd_custom_primary_nav() {
		?>
		<form class="form-inline my-2 my-md-0 ml-lg-3">
			<input class="form-control" placeholder="Search" type="text">
		</form>
		<?php
	}

?>

<?php
/**
 * The template for displaying the header
 */
?><!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'themedd_site_before' ); ?>

<?php
// 1.
?>

<header>
	<nav class="navbar navbar-expand-lg navbar-light px-0 mb-3">
		<div class="container">
		<a class="navbar-brand" href="#">Themedd 1</a>
		<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample05" aria-controls="navbarsExample05" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="navbar-collapse collapse" id="navbarsExample05" style="">
			<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Link One</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Link Two</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
				<div class="dropdown-menu" aria-labelledby="dropdown05">
				<a class="dropdown-item" href="#">Action</a>
				<a class="dropdown-item" href="#">Another action</a>
				<a class="dropdown-item" href="#">Something else here</a>
				</div>
			</li>
			</ul>
			
			<?php echo themedd_edd_load_nav_cart()->cart(); ?>

			<?php echo themedd_custom_search_form(); ?>
		
		</div>
		</div>
	</nav>
</header>

<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>

<hr />

<?php
// 2.
?>

<div>

	<div class="navbar navbar-expand-lg navbar-light px-0">
		<div class="container">

			<a class="navbar-brand" href="#">Themedd 2</a>

			<div class="d-inline-flex">

				<?php 
				echo themedd_edd_load_nav_cart()->cart( 
					array( 
						'cart_option' => 'none', 
						'classes' => array( 'nav-cart', 'd-lg-none', 'd-flex', 'align-items-center', 'px-3' ) 
					) 
				); ?>

				<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-primary" aria-controls="nav-primary" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
		
				
			</div>		

			<nav class="navbar-collapse collapse" id="nav-secondary" style="">
				<ul class="navbar-nav ml-auto navbar-right">
					<li class="nav-item">
						<a class="nav-link" href="#">Secondary One</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Two</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Three</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown02">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>

				<?php echo themedd_edd_load_nav_cart()->cart(); ?>

				<!-- <form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form> -->

			</nav>

			

		</div>
	</div>

	<div class="navbar navbar-expand-lg navbar-light py-0 py-lg-2 px-0 px-lg-3 mb-3">
		<div class="container">
			<nav class="navbar-collapse collapse" id="nav-primary" style="">
				<ul class="navbar-nav mr-auto navbar-left">
					<li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Disabled</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown02">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>
				<form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form>
			</nav>
		</div>
	</div>
	
</div>

<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>

<hr />

<?php
// 3.
?>

<div>

	<div class="navbar navbar-expand-lg navbar-light py-0 py-lg-2 px-lg-3">
		<div class="container">

			<nav class="navbar-collapse collapse" id="nav-secondary" style="">
				<ul class="navbar-nav ml-auto navbar-right">
					<li class="nav-item">
						<a class="nav-link" href="#">Secondary One</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Two</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Three</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown02">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>

				<!-- <form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form> -->

			</nav>

		</div>
	</div>

	<div class="navbar navbar-expand-lg navbar-light px-0 mb-3">
		<div class="container">

			<a class="navbar-brand" href="#">Themedd 3</a>

			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-primary2" aria-controls="nav-primary2" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<nav class="navbar-collapse collapse" id="nav-primary2" style="">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Disabled</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown02">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>
				<form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form>
			</nav>

			

		</div>
	</div>


	
</div>

<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>
<hr />

<?php
// 4.
?>

<div>

	<div class="navbar navbar-expand-lg navbar-light py-0 py-lg-2 px-lg-3">
		<div class="container">

			<nav class="navbar-collapse collapse" id="nav-secondary" style="">
				<ul class="navbar-nav mr-auto navbar-left">
					<li class="nav-item">
						<a class="nav-link" href="#">Secondary One</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Two</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Three</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown02">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>

				<!-- <form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form> -->

			</nav>

		</div>
	</div>

	<div class="navbar navbar-expand-lg navbar-light px-0 mb-3">
		<div class="container">

			<a class="navbar-brand" href="#">Themedd 4</a>

			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-primary4" aria-controls="nav-primary4" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<nav class="navbar-collapse collapse" id="nav-primary4" style="">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Disabled</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown04">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>
				<form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form>
			</nav>

			

		</div>
	</div>


	
</div>

<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>

<hr />


<?php
// 5.
?>

<div>

	<div class="navbar navbar-expand-lg navbar-light py-0 py-lg-2 px-lg-3">
		<div class="container">

			<nav class="navbar-collapse collapse" id="nav-secondary" style="">
				<ul class="navbar-nav mr-auto navbar-left">
					<li class="nav-item">
						<a class="nav-link" href="#">Secondary One</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Two</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Three</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown02">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>

				<form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form>

			</nav>

		</div>
	</div>

	<div class="navbar navbar-expand-lg navbar-light px-0 mb-3">
		<div class="container">

			<a class="navbar-brand" href="#">Themedd 5</a>

			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-primary5" aria-controls="nav-primary5" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<nav class="navbar-collapse collapse" id="nav-primary5" style="">
				<ul class="navbar-nav ml-auto navbar-right">
					<li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Disabled</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown05">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>
				<!-- <form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form> -->
			</nav>

			

		</div>
	</div>


	
</div>

<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>

<hr />


<?php
// 6.
?>

<div>

	<div class="navbar navbar-expand-lg navbar-light py-0 py-lg-2 px-lg-3">
		<div class="container">

		<nav class="navbar-collapse collapse" id="nav-primary6" style="">
				<ul class="navbar-nav mr-auto navbar-left">
					<li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Disabled</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown05">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>
				<!-- <form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form> -->
			</nav>

			<!-- <nav class="navbar-collapse collapse" id="nav-secondary" style="">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="#">Secondary One</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Two</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Three</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown06" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown06">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>

				<form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form>

			</nav> -->

		</div>
	</div>

	<div class="navbar navbar-expand-lg navbar-light px-0 mb-3">
		<div class="container">

			<a class="navbar-brand" href="#">Themedd 6</a>

			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-primary6" aria-controls="nav-primary6" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			

			

		</div>
	</div>


	
</div>

<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>

<hr />


<?php
// 7.
?>
<nav class="navbar navbar-expand-lg navbar-light mb-3">
	<!-- <div class="container"> -->
      <a class="navbar-brand" href="#">Themedd 7</a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-primary7" aria-controls="nav-primary7" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="nav-primary7" style="">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Disabled</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
            <div class="dropdown-menu" aria-labelledby="dropdown05">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>
		</ul>
		
		<?php echo themedd_edd_load_nav_cart()->cart(); ?>

		<?php echo themedd_custom_search_form(); ?>
		
		
	  </div>
	<!-- </div> -->
</nav>

<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>

<hr />

<?php
// 8.
?>
<nav class="navbar navbar-expand-lg navbar-light px-0 mb-3">
	<div class="container navbar-centered">
	
		<div class="navbar-collapse collapse" id="nav-primary8" style="">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Disabled</a>
          </li>
         
        </ul>
	  </div>

	  <a class="navbar-brand m-0" href="#">Themedd 8</a>
	  
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-primary8" aria-controls="nav-primary8" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse">
        
	 	<ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
         
        </ul>
		
		<?php echo themedd_edd_load_nav_cart()->cart(); ?>

	  </div>

	</div>
</nav>

<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>

<hr />


<?php
// 9.
?>

<div>

	<div class="navbar navbar-expand-lg navbar-light px-0">
		<div class="container justify-content-lg-center">

			<a class="navbar-brand m-0" href="#">Themedd 9</a>

			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-primary9" aria-controls="nav-primary9" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		</div>
	</div>

	<div class="navbar navbar-expand-lg navbar-light py-0 py-lg-2 px-lg-3 mb-3">
		<div class="container">

		<nav class="navbar-collapse collapse justify-content-lg-center" id="nav-primary9" style="">
				<ul class="navbar-nav">
					<li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Disabled</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown09">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>

				<?php echo themedd_edd_load_nav_cart()->cart(); ?>

				<!-- <form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form> -->
			</nav>

			<!-- <nav class="navbar-collapse collapse" id="nav-secondary" style="">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="#">Secondary One</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Two</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Three</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown06" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown06">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>

				<form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form>

			</nav> -->

		</div>
	</div>

	


	
</div>

<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>

<hr />

<?php
// 10.
?>

<div>
	
	<div class="navbar navbar-expand-lg navbar-light py-0 py-lg-2">
		<div class="container justify-content-lg-center">
			<nav class="navbar-collapse collapse" id="nav-secondary" style="">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<a class="nav-link" href="#">Secondary One</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Two</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Three</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown06" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown06">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>

				<?php echo themedd_edd_load_nav_cart()->cart(); ?>

			</nav>
		</div>	
	</div>

	<div class="navbar navbar-expand-lg navbar-light px-0">
		<div class="container justify-content-lg-center">

			<a class="navbar-brand m-0" href="#">Themedd 10</a>

			<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-primary10" aria-controls="nav-primary10" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		</div>
	</div>

	<div class="navbar navbar-expand-lg navbar-light py-0 py-lg-2 px-lg-3 mb-3">
		<div class="container">

			<nav class="navbar-collapse collapse justify-content-lg-center" id="nav-primary10" style="">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="#">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Disabled</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown10">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>
				<!-- <form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form> -->
			</nav>

		</div>
	</div>

</div>

<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>

<hr />

<?php
// 11.
?>
<nav class="navbar navbar-expand-lg navbar-light px-0 mb-3">
	<div class="container navbar-centered">
	
		<div class="navbar-collapse collapse" id="nav-primary11" style="">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Disabled</a>
          </li>
         
        </ul>
	  </div>

	  <a class="navbar-brand mx-lg-5" href="#">Themedd 11</a>
	  
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-primary11" aria-controls="nav-primary11" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse">
        
	 	<ul class="navbar-nav mr-auto">

          <li class="nav-item">
            <a class="nav-link" href="#">Link One</a>
		  </li>
		  
		  <li class="nav-item">
            <a class="nav-link" href="#">Link Two</a>
		  </li>
		  
		  <li class="nav-item">
            <a class="nav-link" href="#">Link Three</a>
          </li>
         
        </ul>
		
		<?php echo themedd_edd_load_nav_cart()->cart(); ?>

	  </div>

	</div>
</nav>
<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>

<hr />


<?php
// 12.
?>
<nav class="navbar navbar-expand-lg navbar-light px-0 mb-3">
	<div class="container">
      <a class="navbar-brand" href="#">Themedd 12</a>
      <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-primary12" aria-controls="nav-primary12" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse collapse" id="nav-primary12">

		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Link</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#">Disabled</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown12" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
				<div class="dropdown-menu" aria-labelledby="dropdown12">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<a class="dropdown-item" href="#">Something else here</a>
				</div>
			</li>
		</ul>
		
		<a class="btn btn-outline-primary" href="/pricing/">Start Selling</a>
		
		<?php do_action( 'themedd_secondary_menu_after' ); ?>

	  </div>
	</div>
</nav>

<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>

<hr />


<?php
// 13.
?>
<nav class="navbar navbar-expand-lg navbar-light mb-3">
	<div class="container">
		<a class="navbar-brand" href="#">Themedd 13</a>

		<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-primary13" aria-controls="nav-primary13" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

	<div class="navbar-collapse collapse" id="nav-primary13">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active">
				<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Link</a>
			</li>
			<li class="nav-item">
				<a class="nav-link disabled" href="#">Disabled</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown05" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
				<div class="dropdown-menu" aria-labelledby="dropdown05">
					<a class="dropdown-item" href="#">Action</a>
					<a class="dropdown-item" href="#">Another action</a>
					<a class="dropdown-item" href="#">Something else here</a>
				</div>
			</li>
		</ul>

		<?php echo themedd_edd_load_nav_cart()->cart(); ?>

		<?php //echo themedd_custom_search_form(); ?>

	</div>
	</div>
</nav>

<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>

<hr />

<?php
// 14.
?>

<header>

	<div class="navbar navbar-expand-lg navbar-light px-0">
		<div class="container">

			<a class="navbar-brand" href="#">Themedd 14</a>

			<div class="d-inline-flex">

				<?php 
				echo themedd_edd_load_nav_cart()->cart( 
					array( 
						'cart_option' => 'none', 
						'classes' => array( 'nav-cart', 'd-lg-none', 'd-flex', 'align-items-center', 'px-3' ) 
					) 
				); ?>

				<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#nav-primary14" aria-controls="nav-primary14" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
		
				
			</div>		

			<nav class="navbar-collapse collapse" id="nav-secondary">
				<ul class="navbar-nav ml-auto navbar-right">
					<li class="nav-item">
						<a class="nav-link" href="#">Secondary One</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Two</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Three</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown02">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>

				<?php echo themedd_edd_load_nav_cart()->cart(); ?>

				<!-- <form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form> -->

			</nav>

			

		</div>
	</div>

	<div class="navbar navbar-expand-lg navbar-light py-0 py-lg-2 px-0 px-lg-3 mb-3">
		<div class="container">
			<nav class="navbar-collapse collapse" id="nav-primary14">
				<ul class="navbar-nav mr-auto navbar-left">
					<li class="nav-item active">
						<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">Link</a>
					</li>
					<li class="nav-item">
						<a class="nav-link disabled" href="#">Disabled</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
						<div class="dropdown-menu" aria-labelledby="dropdown02">
							<a class="dropdown-item" href="#">Action</a>
							<a class="dropdown-item" href="#">Another action</a>
							<a class="dropdown-item" href="#">Something else here</a>
						</div>
					</li>
				</ul>
				<form class="form-inline my-2">
					<input class="form-control" placeholder="Search" type="text">
				</form>
			</nav>
		</div>
	</div>
	
</header>

<div class="content-wrapper">
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin convallis maximus felis, ut maximus orci. Integer tempor justo justo, ut porta felis hendrerit vel. Integer sagittis et augue vel fermentum. Nunc scelerisque fermentum aliquet.</p>
</div>

<hr />


<?php wp_footer(); ?>