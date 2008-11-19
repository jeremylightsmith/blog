module ApplicationHelper
  def button_to(name, url)
    %{<a href="#{url}" class="button">#{name.upcase}</a>}
  end
end