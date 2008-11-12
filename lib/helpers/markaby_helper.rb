module Helpers
  module MarkabyHelper
    def markaby(&block)
      Markaby::Builder.new({}, self, &block).to_s
    end
  end
end