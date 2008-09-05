require File.dirname(__FILE__) + '/spec_helper'
require 'html_generator'

describe HtmlGenerator do
  before do
    @gen = HtmlGenerator.new
  end
  
  it "should separate files into name & extension" do
    @gen.separate("file_like object.red").should == ["file_like object", "red"]
  end
  
  it "should only consider last extension" do
    @gen.separate("my_file.red.erb").should == ["my_file.red", "erb"]
  end
end