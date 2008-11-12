module Generators
  class PatternGenerator
    def process(context, content)
      name = File.basename(context.file_name).gsub(".pattern.yml", "")
      context.pattern = Pattern.new(name.to_sym, content)
      context.layout :pattern
      content = context.process_file(context.layout_template, context, false)
      context.layout :application
      content
    end
  end
end
