class String
  def split_filename
    if self =~ /^(.+)\.([^\.]+)$/
      [$1, $2]
    else
      [self, nil]
    end
  end
  
  def extension
    split_filename[1]
  end
end