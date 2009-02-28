module YouTubeHelper
  def movie(url)
    <<-HTML
    <object width="425" height="344">
      <param name="movie" value="#{url}&hl=en&fs=1&rel=0&color1=0x234900&color2=0x4e9e00"></param>
      <param name="allowFullScreen" value="true"></param>
      <param name="allowscriptaccess" value="always"></param>
      <embed src="#{url}&hl=en&fs=1&rel=0&color1=0x234900&color2=0x4e9e00" 
             type="application/x-shockwave-flash" 
             allowscriptaccess="always" 
             allowfullscreen="true" 
             width="425" 
             height="344"></embed>
    </object>
    HTML
  end
end