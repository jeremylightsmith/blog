module UrlHelper
  def link_to(name, url, options = {})
    options = options.map {|key, value| %{ #{key}="#{value}"}}.join
    %{<a href="#{url}"#{options}>#{name}</a>}
  end
  
  def image_tag(name, options = {})
    options = options.map {|key, value| %{ #{key}="#{value}"}}.join
    %{<img src="#{name}"#{options}/>}
  end
end