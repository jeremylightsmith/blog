require 'rubygems'

gem 'activesupport'
require 'active_support'

gem 'RedCloth'
require 'redcloth'

gem 'markaby'
require 'markaby'

require 'erb'
require 'yaml'

$LOAD_PATH << File.expand_path(File.dirname(__FILE__))

require 'extensions/string'
require 'helpers/url_helper'
require 'helpers/markaby_helper'
require 'helpers/form_helper'

require 'html_generator'
require 'site_generator'

require 'pattern'
require 'pattern_links_extension'
