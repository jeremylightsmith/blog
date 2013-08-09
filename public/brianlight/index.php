<?php $css = "home-page"; ?>
<?php include ( "_header.php" ); ?>

<!-- hero -->
<div class="hero stripe">
  <div class="container">
    <!-- <img src="images/banners/dan_kitchen.jpg"/> -->
    <!-- <img src="images/banners/bathroom.jpg"/> -->

    <div id="hero-carousel" class="carousel slide">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#hero-carousel" data-slide-to="0" class="active"></li>
        <li data-target="#hero-carousel" data-slide-to="1"></li>
        <li data-target="#hero-carousel" data-slide-to="2"></li>
        <li data-target="#hero-carousel" data-slide-to="3"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner">
        <div class="item active">
          <img src="images/banners/dan_kitchen.jpg" alt="">
          <div class="carousel-caption">
            <h3>My promise to you</h3>
            <p>quality work, a fair price, piece of mind.</p>
          </div>
        </div>
        <div class="item">
          <img src="images/banners/dan_fence.jpg" alt="">
          <div class="carousel-caption">
            <h3>Fences</h3>
            I do yards, check out the fence, yo!
          </div>
        </div>
        <div class="item">
          <img src="images/banners/bathroom.jpg" alt="">
          <div class="carousel-caption">
            Bathrooms are fun, yo!
          </div>
        </div>
        <div class="item">
          <img src="images/banners/school_outdoors.jpg" alt="">
          <div class="carousel-caption">
            And this outdoors is sweeeeet!
          </div>
        </div>
      </div>

      <!-- Controls -->
      <a class="left carousel-control" href="#hero-carousel" data-slide="prev">
        <span class="icon-prev"></span>
      </a>
      <a class="right carousel-control" href="#hero-carousel" data-slide="next">
        <span class="icon-next"></span>
      </a>
    </div>
  </div>
</div>

<div class="container">
  <h2>Happy Clients</h2>

  <div class="row">
    <div class="col-4">
      <!-- dan -->
      <div class="video-wrapper"><iframe src="//www.youtube.com/embed/3gdcFVQX24Y?hd=1&rel=0&autohide=1&showinfo=0" frameborder="0" allowfullscreen></iframe></div>
      
      <blockquote>
        <p>...[Brian] repiped, rewired, built a new kitchen, and a new bathroom, did the entire upstairs, and built a fence for us...</p>
        <p>...he gave us an estimate and a calendar that was really good, and stuck with it...</p>
        <p>...the work that has been done has been excellent, we are extremely satisfied with it and the process. I would highly recommend Brian as a contractor...</p>

        <p class="by">- Dan &amp; Christina</p>
      </blockquote>
    </div>

    <div class="col-4">
      <!-- michael -->
      <div class="video-wrapper"><iframe src="//www.youtube.com/embed/1cof_D8Hoh4?hd=1&rel=0&autohide=1&showinfo=0" frameborder="0" allowfullscreen></iframe></div>
      
      <blockquote>
        <p>My wife and i just bought a new home...Brian tore out a wall, finished the unfinished basement, remodeled the bathroom, did a lot of tiling for us and laid our wood floors. The best part of what Brian did for us is that he would just do odds and ends before we even asked him to and it really polished the place up.</p>
        <p>I give brian a five star rating!</p>
        <p class="by">- Michael &amp; Emily Smith</p>
      </blockquote>
    </div>

    <div class="col-4">
      <div class="video-wrapper"><iframe src="//www.youtube.com/embed/03V5obaU6FE?hd=1&rel=0&autohide=1&showinfo=0" frameborder="0" allowfullscreen></iframe></div>

      <blockquote>
      </blockquote>

    </div>
  </div>
</div>

<script type="text/javascript">
$(function() {
  // $('.carousel').carousel();
});
</script>


<?php include ( "_footer.php" ); ?>
