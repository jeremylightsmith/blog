module Helpers
  module UrlHelper
    def link_to(name, url, options = {})
      options = options.map {|key, value| %{ #{key}="#{value}"}}.join
      %{<a href="#{url}"#{options}>#{name}</a>}
    end
  
    def link_to_function(name, function, options = {})
      options = options.map {|key, value| %{ #{key}="#{value}"}}.join
      %{<a href="#" onclick="#{function};return false;"#{options}>#{name}</a>}
    end
  
    def image_tag(url, options = {})
      options = options.map {|key, value| %{ #{key}="#{value}"}}.join
      url = "images/#{url}" unless url =~ /^https?\:\/\//
      %{<img src="#{url}"#{options}/>}
    end
    
    def stylesheet_link_tag(name, options = {})
      options = options.map {|key, value| %{ #{key}="#{value}"}}.join
      %{<link href="stylesheets/intro.css" rel="stylesheet" type="text/css"#{options}>}
    end
  end
end