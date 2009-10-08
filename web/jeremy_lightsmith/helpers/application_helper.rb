module ApplicationHelper
  def nav_links
    links = []
    links << link_to("home", "/")
    links << link_to("services", "/services.html")
    links << link_to("classes", "/classes.html")
    links << link_to("blog", "http://onemanswalk.com/work")
    links << link_to("facilitation patterns", "http://facilitationpatterns.org/")
  end
  
  def what_i_offer
    <<-HTML
      <div class="box">
        <h2>What I offer</h2>
        <ul>
          <li>
            #{ link_to "Requirements Discovery Workshops", "/services.html#requirements_discovery_workshops" }
            <div class="hint">build the right product</div>
          </li>
          <li>
            #{ link_to "Agile/Scrum Enablement", "/services.html#agile_enablement" }
            <div class="hint">deliver it when you said you would</div>
          </li>
          <li>
            #{ link_to "Retrospectives", "/services.html#retrospectives" }
            <div class="hint">adopt a culture of innovation</div>
          </li>
          <li>
            #{ link_to "Developer Best Practice Workshops", "/services.html#best_practices" }
            <div class="hint">make it all fun</div>
          </li>
        </ul>
      </div>
    HTML
  end
  
  def tracking_code
    <<-HTML
    <script type="text/javascript">
      var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
      document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
      try {
        var pageTracker = _gat._getTracker("UA-11025364-1");
        pageTracker._trackPageview();
      } catch(err) {}
    </script>
    HTML
  end
end