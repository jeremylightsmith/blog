module ApplicationHelper
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
end