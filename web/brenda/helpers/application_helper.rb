module ApplicationHelper
  def button_to(name, url)
    %{<a href="#{url}" class="button">#{name.upcase}</a>}
  end
  
  def heading(name)
    content_for(:title) { name.to_s.titleize }
    image_tag "text/#{name}.gif", :class => 'heading'
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