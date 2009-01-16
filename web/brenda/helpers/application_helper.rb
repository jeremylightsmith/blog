module ApplicationHelper
  def button_to(name, url)
    %{<a href="#{url}" class="button">#{name.upcase}</a>}
  end
  
  # size can be :small or :medium
  def photo_link(name, size = :small)
    link_to image_tag("photos/#{name}", :class => size), ""
  end

  def photo_links(names, size = :small)
    "<div class='photos'>" + 
    names.map {|name| photo_link(name, size)}.join(" ") +
    "</div>"
  end
  
  def gallery(selector, options = {})
    options = {
      :api_key => "1df4861d8818ad25429e8302d6561f07",
      :type => "photoset",
      :thumb_size => "m",
      :per_page => 500
    }.merge(options)
    options = options.map {|key,value| "#{key}:#{value.inspect}"}.join(",")

    js = "$('#{selector}').flickr({#{options}});"
    "<script type='text/javascript' charset='utf-8'>$(function() {#{js}})</script>"
  end
end