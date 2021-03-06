
<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>Wobbly Slideshow Effect</title>
		<meta name="description" content="Wobbly slideshow effect using Snap.svg" />
		<meta name="keywords" content="slideshow, wobbly, jelly, effect, svg, snap.svg, web design" />
		<meta name="author" content="Codrops" />
		<link rel="shortcut icon" href="../favicon.ico">
		<link href='https://fonts.googleapis.com/css?family=Flamenco' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="css/slideshow.css" />
		<script src="js/snap.svg-min.js"></script>
		<script src="js/modernizr.custom.js"></script>
		<!--[if IE]>
  		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-7243260-2']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>

	</head>
	<body>
		<div class="container">
			<div id="slideshow" class="slideshow">
				<ul>
					<li>
						<div class="slide">
							<div class="codrops-links">
								<a class="codrops-icon codrops-icon-prev" href="http://tympanus.net/Development/TooltipStylesInspiration/"><span>Previous Demo</span></a>
								<a class="codrops-icon codrops-icon-drop" href="http://tympanus.net/codrops/?p=20714"><span>Back to the Codrops Article</span></a>
							</div>
							<img class="icon" src="img/icons/browser.svg" alt="Browser Icon"/>
							<h1>Wobbly Slideshow Effect</h1>
							<p>Based on the Dribble shot <br /><a href="https://dribbble.com/shots/1701001-GIF-Exercise">GIF Exercise</a> by <a href="https://dribbble.com/SergeyValiukh">Sergey Valiukh</a></p>
						</div>
					</li>
					<li>
						<div class="slide">
							<img class="icon" src="img/icons/heart.svg" alt="Heart Icon"/>
							<blockquote>
								<p>Never fear quarrels, but seek hazardous adventures.</p>
							</blockquote>
							<p>Alexandre Dumas</p>
						</div>
					</li>
					<li>
						<div class="slide">
							<img class="icon" src="img/icons/letter.svg" alt="Letter Icon"/>
							<blockquote>
								<p>If you don't know where you are going, any road will get you there.</p>
							</blockquote>
							<p>Lewis Carroll</p>
						</div>
					</li>
					<li>
						<div class="slide">
							<img class="icon" src="img/icons/football.svg" alt="Football Icon"/>
							<blockquote>
								<p>Procrastination is the art of keeping up with yesterday.</p>
							</blockquote>
							<p>Don Marquis</p>
						</div>
					</li>
					<li>
						<div class="slide">
							<img class="icon" src="img/icons/match.svg" alt="Match Icon"/>
							<blockquote>
								<p>I'm an idealist. I don't know where I'm going, but I'm on my way.</blockquote>
							<p>Carl Sandburg</p>
						</div>
					</li>
					<li>
						<div class="slide">
							<img class="icon" src="img/icons/watch.svg" alt="Watch Icon"/>
							<blockquote>
								<p>I refuse to join any club that would have me as a member.</blockquote>
							<p>Groucho Marx</p>
						</div>
					</li>
					<li>
						<div class="slide">
							<div class="codrops-links">
								<a class="codrops-icon codrops-icon-prev" href="http://tympanus.net/Development/TooltipStylesInspiration/"><span>Previous Demo</span></a>
								<a class="codrops-icon codrops-icon-drop" href="http://tympanus.net/codrops/?p=20714"><span>Back to the Codrops Article</span></a>
							</div>
							<div class="related">
								<p>If you enjoyed this demo you might also like:</p>
								<a href="http://tympanus.net/Tutorials/PagePreloadingEffect/">
									<img src="img/related/PagePreloadingEffect.png" />
									<h3>Page Preloading Effect</h3>
								</a>
								<a href="http://tympanus.net/Development/ButtonComponentMorph/">
									<img src="img/related/MorphingButtons.png" />
									<h3>Morphing Buttons</h3>
								</a>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div><!-- /container -->
		<script src="js/classie.js"></script>
		<script src="js/sliderFx.js"></script>
		<script>
			(function() {
				new SliderFx( document.getElementById('slideshow'), {
					easing : 'cubic-bezier(.8,0,.2,1)'
				} );
			})();
		</script>
		

<!-- For the demo ad only -->   
<script src="//tympanus.net/codrops/adpacks/demoad.js"></script>

	</body>
</html>