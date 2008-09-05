require 'pattern'

class HtmlGenerator
  def initialize
    @context = Context.new
    @context.patterns = Patterns.load
    @context.patterns_by_category = {}
    @context.patterns.each do |pattern|
      (@context.patterns_by_category[pattern.category] ||= []) << pattern
    end
  end
  
  def process(file_name, content, apply_layout = true)
    file_name, extension = separate(file_name)

    case extension
    when 'erb'
      content = ERB.new(content, 0, "%<>").result(@context.get_binding)
      
    when 'red'
      content = RedCloth.new(content).to_html
      
    when 'yml'
      content = YAML::load(content) rescue raise("error reading #{file_name}: #{$!.message}")
      
    when 'pattern'
      @context.pattern = Pattern.new(file_name.to_sym, content)
      content = process_file(File.dirname(__FILE__) + "/../facilitation_patterns/layouts/pattern.red.erb", false)

    when nil
      if apply_layout
        @context.content = content
        return process_file(File.dirname(__FILE__) + "/../facilitation_patterns/layouts/application.html.erb", false)
      else
        return content
      end
    end

    return process(file_name, content, apply_layout)
  end
      
  def process_file(file, apply_layout = true)
    process(File.basename(file), File.read(file), apply_layout)
  end
  
  def write_page(in_file, out_file)
    File.open(out_file, "w") do |f| 
      f << process_file(in_file)
    end
  end
  
  def separate(file_name)
    if file_name =~ /^(.+)\.([^\.]+)$/
      [$1, $2]
    else
      [file_name, nil]
    end
  end
  
  class Context
    attr_accessor :pattern, :patterns, :patterns_by_category, :content
    
    def get_binding
      binding
    end
  end
end