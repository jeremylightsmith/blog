require 'pattern'

class HtmlGenerator
  def initialize(template_directory)
    @template_directory = template_directory
    @global_context = GlobalContext.new
    load_patterns
  end
  
  def write_page(in_file, out_file)
    File.open(out_file, "w") do |f| 
      f << process_file(in_file)
    end
  end

  def process_file(file, context = new_context, apply_layout = true)
    process(File.basename(file), File.read(file), context, apply_layout)
  rescue
    $stderr.puts "error processing #{file}"
    raise
  end  

  def process(file_name, content, context = new_context, apply_layout = true)
    file_name, extension = file_name.split_filename

    case extension
    when 'erb'
      content = ERB.new(content, 0, "%<>").result(context.get_binding)
      
    when 'mab'
      builder = Markaby::Builder.new({}, context)
      builder.instance_eval content, file_name
      content = builder.to_s
      
      
    when 'red'
      redcloth = RedCloth.new(content)
      redcloth.patterns = context.patterns
      content = redcloth.to_html(:html, :textile, :refs_patterns)
      
    when 'yml'
      content = YAML::load(content) rescue raise("error reading #{file_name}: #{$!.message}")
            
    when 'pattern'
      context.pattern = Pattern.new(file_name.to_sym, content)
      context.layout :pattern
      content = process_file(context.layout_template, context, false)
      context.layout :application

    when nil
      if apply_layout && context.layout_template
        context.content = content
        return process_file(context.layout_template, context, false)
      else
        return content
      end
    end

    return process(file_name, content, context, apply_layout)
  end
  
  private
  
  def load_patterns
    unless @global_context.patterns
      @global_context.patterns = Patterns.load(@template_directory)
      @global_context.patterns_by_category = {}
      @global_context.patterns.each do |pattern|
        (@global_context.patterns_by_category[pattern.category] ||= []) << pattern
      end
    end
  end
  
  def new_context
    PageContext.new(@template_directory, @global_context)
  end
  
  class PageContext
    include Helpers::FormHelper
    include Helpers::UrlHelper
    include Helpers::MarkabyHelper
    attr_accessor :global_context, :layout_template, :pattern, :content
    
    def initialize(template_directory, global_context)
      @template_directory, @global_context = template_directory, global_context
      layout(:application) rescue nil
    end
    
    def layout(name)
      if name
        files = Dir[File.join(@template_directory, 'layouts', "#{name}.*")]
        raise "couldn't find layout #{name}" if files.empty?
        @layout_template = files.first
      else
        @layout_template = nil
      end
    end
    
    def helper(name)
      file_name = "#{name}_helper"
      class_name = file_name.classify
      helper = begin
        class_name.constantize
      rescue NameError # this constant hasn't been loaded yet
        require File.join(@template_directory, "helpers", file_name)
        class_name.constantize
      end
      
      metaclass.send(:include, helper)
    end
    
    def content_for(name) 
      metaclass.send(:attr_accessor, "content_for_#{name}".to_sym)
      send("content_for_#{name}=".to_sym, yield)
    end
    
    def get_binding
      binding
    end
    
    def method_missing(sym, *args)
      return @global_context.send(sym, *args) if @global_context.respond_to?(sym)

      name = sym.to_s
      if name.starts_with?("content_for_") && name.ends_with?("?")
        return !!instance_variable_get("@#{name[0..-2]}")
      end

      super
    end
    
    private
    
    def metaclass 
      class << self; self; end # according to why...
    end
  end
  
  class GlobalContext
    attr_accessor :patterns, :patterns_by_category
    
    def link_to(name, url = nil)
      url ||= name + ".html"
      "<a href='#{url}'>#{name}</a>"
    end
  end
end