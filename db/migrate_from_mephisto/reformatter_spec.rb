require 'rubygems'
require 'spec'
require File.dirname(__FILE__) + "/reformatter"

describe Reformatter do
  attr_reader :reformatter, :unknown_tags, :links
  
  before do
    @reformatter = Reformatter.new

    @unknown_tags = []
    @reformatter.handle_unknown_tags = proc {|tag| @unknown_tags << tag; tag}

    @links = []
    @reformatter.handle_links = proc {|name, url| @links << [name, url]}
  end
  
  it "should reformat typo:code" do
    input = <<-IN
Pull up textmate and type :

<typo:code>
command-option-M
command-shift-L
</typo:code>

This will start recordin

<typo:code>
your mom
</typo:code>
    IN
    
    output = <<-OUT
Pull up textmate and type :

<pre>
command-option-M
command-shift-L
</pre>

This will start recordin

<pre>
your mom
</pre>
    OUT
    
    reformatter.reformat(input).should == output
  end

  it "should reformat typo:code" do
    input = <<-IN
Pull up textmate and type :

<typo:code lang="ruby">
command-option-M
command-shift-L
</typo:code>

This will start recordin

<filter:code lang="ruby">
your mom
</filter:code>
    IN

    output = <<-OUT
Pull up textmate and type :

<pre lang="ruby">
command-option-M
command-shift-L
</pre>

This will start recordin

<pre lang="ruby">
your mom
</pre>
    OUT

    reformatter.reformat(input).should == output
  end
  
  it "should skip unknown tags but add to list" do
    input = <<-IN
<typo:code lang="ruby">
  <pre>stuff</pre>
command-shift-L
</typo:code>
<b>bold</b>
    IN

    output = <<-OUT
<pre lang="ruby">
  <pre>stuff</pre>
command-shift-L
</pre>
<b>bold</b>
    OUT

    reformatter.reformat(input).should == output
    unknown_tags.should == ["<b>", "</b>"]
  end
  
  it "should process flickr tags" do
    input = <<-IN
<typo:flickr img="123" size="small" style="float:right"/>
<typo:flickr img="456" size="square" style="float:left"/>
<filter:flickr img="456" size="square" style="float:left"/>
<filter:flickr img="456" size="square" style="float:left" />
<filter:flickr img="456" style="float:left" />
<typo:flickr img="789" size="small"/>
<typo:flickr img="789" size="small" />
    IN

    output = <<-OUT
<div class="right">[img:123,small]</div>
<div class="left">[img:456,square]</div>
<div class="left">[img:456,square]</div>
<div class="left">[img:456,square]</div>
<div class="left">[img:456,small]</div>
[img:789,small]
[img:789,small]
    OUT

    reformatter.reformat(input).should == output
  end
  
  it "should replace <br>'s" do
    input = <<-IN
hello
world<br>hello<br>
world<br><br>

hello</br>world
hello<br/>
world
    IN

    output = <<-OUT
hello
world
hello
world


hello
world
hello
world
    OUT

    reformatter.reformat(input).should == output
  end
  
  it "should remember links" do
    input = %{some "text":http://google.com/ with "link":/something}
    reformatter.reformat(input).should == input
    links.should == [["text", "http://google.com/"],["link", "/something"]]
  end
  
  # imgset:id,size
end