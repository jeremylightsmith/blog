module JeremyAndKarissaHelper
  def flag(language)
    # current_language = session[:language] || "english"
    # if current_language == language.to_s
      image_tag "disabled_#{language}.png"
    # else
    #   link_to image_tag("#{language}.png"), "/set_language/#{language}" 
    # end
  end
    
  def the_template_path(action_name)
    path = "app/views/#{params[:controller]}/#{action_name}"
    path << ".spanish" if session[:language] == "spanish"
    path
  end
end