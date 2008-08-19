class Reformatter
  attr_accessor :handle_links, :handle_unknown_tags
  attr_reader :links
  
  def initialize
    @links = []
    @handle_unknown_tags = proc {|tag| tag }
    @handle_links = proc {|name, url| }
  end
  
  def reformat(string)
    string.gsub!(/\<\/?br\/?\>\n?/, "\n")
    
    in_code = false
    string.gsub!(/(\<[^\>]+\>)/) do |tag|
      case tag
      when /^\<(typo|filter):code/ 
        raise "nested code tags" if in_code
        in_code = true
        tag.gsub(/^\<(typo|filter):code/, "<pre")
      when /^\<\/(typo|filter):code\>/
        raise "end code tag w/ no begin" unless in_code
        in_code = false
        "</pre>"
      when /^\<(typo|filter):flickr img=\"([^\"]+)\" size=\"([^\"]+)\" style=\"float:([^\"]+)\" ?\/\>/
        %{<div class="#{$4}">[img:#{$2},#{$3}]</div>}
      when /^\<(typo|filter):flickr img=\"([^\"]+)\" style=\"float:([^\"]+)\" ?\/\>/
        %{<div class="#{$3}">[img:#{$2},small]</div>}
      when /^\<(typo|filter):flickr img=\"([^\"]+)\" size=\"([^\"]+)\" ?\/\>/
        %{[img:#{$2},#{$3}]}
      else
        if !in_code
          handle_unknown_tags.call(tag)
        else
          tag
        end
      end
    end
      
    string.scan(/\"([^\"]+)\"\:([\w\/\:\.-]+)/) {|name, url| handle_links.call(name, url) }

    string
  end
end