module ApplicationHelper
  def tab(name, url)
    formatted_name = name.split(" ").map {|word| "<span class='big'>#{word[0..0]}</span>#{word[1..-1]}"}.join(" ")
    css_class = content_for_current_tab == name ? "here" : ""
    
    "<li>#{link_to formatted_name, url, :class => css_class }</li>"
  end
end