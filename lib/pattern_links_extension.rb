module PatternLinksExtension
  def patterns=(patterns)
    @patterns = patterns
  end
  
  def refs_patterns(text)
    text.gsub!(/\[([a-z0-9_]+)\]/) do |m|
      pattern = @patterns[$1]
      if pattern
        "<a href='#{$1}.html' class='pattern_link'>[#{pattern.name}]</a>"
      else
        "<span class='unknown_pattern_link'>[#{$1}?]</span>"
      end
    end
  end
end

RedCloth.send(:include, PatternLinksExtension)
