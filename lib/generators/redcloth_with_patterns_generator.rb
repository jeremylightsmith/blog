module Generators
  class RedclothWithPatternsGenerator
    def process(context, content)
      redcloth = RedCloth.new(content)
      redcloth.patterns = context.patterns
      redcloth.to_html(:html, :textile, :refs_patterns)
    end
  end
end
