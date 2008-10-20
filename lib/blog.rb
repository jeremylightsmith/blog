require 'rubygems'

gem 'activesupport'
require 'active_support'

gem 'RedCloth'
require 'redcloth'

require 'erb'
require 'yaml'

$LOAD_PATH << File.expand_path(File.dirname(__FILE__))

require 'extensions/string'
require 'site_generator'
require 'html_generator'
require 'pattern'
require 'pattern_links_extension'