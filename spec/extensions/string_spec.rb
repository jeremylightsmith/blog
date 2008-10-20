require File.dirname(__FILE__) + '/../spec_helper'

describe String do
  it "should know how to separate it's extension" do
    "some file called.txt".split_filename.should == ["some file called", "txt"]
    "a.html.erb".split_filename.should == ["a.html", "erb"]
    "a.pdf.html.erb".split_filename.should == ["a.pdf.html", "erb"]
    "apple".split_filename.should == ["apple", nil]
  end
  
  it "should know it's extension" do
    "a.txt".extension.should == "txt"
    "a.html.erb".extension.should == "erb"
    "apple".extension.should == nil
  end
end