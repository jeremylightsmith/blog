module JeremyAndKarissaHelper
  def flag(language)
    # current_language = session[:language] || "english"
    # if current_language == language.to_s
      image_tag "disabled_#{language}.png"
    # else
    #   link_to image_tag("#{language}.png"), "/set_language/#{language}" 
    # end
  end
    
  def header(site, &block)
    markaby do
      div.header! do
        div(:style => "height:140px;") do
          div.jeremy_and_karissa do
            link_to image_tag("logo.png"), "/"
          end
          div.top_menu do 
            link_to "Exchange", "/exchange", :class => (site == :exchange ? "selected" : "")
            link_to "Wedding", "/wedding", :class => (site == :wedding ? "selected" : "")
          end
          div.flags do
            flag :english
            flag :spanish
          end
        end
        div.sub_menu do
          instance_eval(&block)
        end
      end
    end
  end
  
  def the_template_path(action_name)
    path = "app/views/#{params[:controller]}/#{action_name}"
    path << ".spanish" if session[:language] == "spanish"
    path
  end
  
  def dj_image(name)
    image_tag "http://burnblue.org/burn_blue/images/contacts/#{name}.jpg"
  end
end