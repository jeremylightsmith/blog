require 'pattern'

class HtmlGenerator
  def initialize(template_directory)
    @template_directory = template_directory
    @context = Context.new
    @layout_directory = File.join(template_directory, "layouts")
    load_patterns
  end
  
  def process(file_name, content, apply_layout = true)
    file_name, extension = file_name.split_filename

    case extension
    when 'erb'
      content = ERB.new(content, 0, "%<>").result(@context.get_binding)
      
    when 'red'
      redcloth = RedCloth.new(content)
      redcloth.patterns = @context.patterns
      content = redcloth.to_html(:html, :textile, :refs_patterns)
      
    when 'yml'
      content = YAML::load(content) rescue raise("error reading #{file_name}: #{$!.message}")
            
    when 'pattern'
      @context.pattern = Pattern.new(file_name.to_sym, content)
      content = use_layout("pattern")

    when nil
      if apply_layout
        @context.content = content
        return use_layout("application")
      else
        return content
      end
    end

    return process(file_name, content, apply_layout)
  end
  
  def use_layout(name)
    files = Dir["#{@layout_directory}/#{name}.*"]
    raise "couldn't find layout #{name}" if files.empty?
    process_file(files.first, false)
  end
  
  def load_patterns
    unless @context.patterns
      @context.patterns = Patterns.load(@template_directory)
      @context.patterns_by_category = {}
      @context.patterns.each do |pattern|
        (@context.patterns_by_category[pattern.category] ||= []) << pattern
      end
    end
  end
      
  def process_file(file, apply_layout = true)
    process(File.basename(file), File.read(file), apply_layout)
  end
  
  def write_page(in_file, out_file)
    File.open(out_file, "w") do |f| 
      f << process_file(in_file)
    end
  end
    
  class Context
    attr_accessor :pattern, :patterns, :patterns_by_category, :content
    
    def get_binding
      binding
    end
  end
end