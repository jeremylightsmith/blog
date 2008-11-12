module BluesHeroHelper
  def teacher(sym, name, super_powers = "", bio = "") 
    %{
      <div class="teacher">
        <a name="#{sym}"/>
        #{image_tag "#{sym}.jpg"}
        
        <table border="2" cellspacing="0">
          <tr>
            <th>Name:</th>
            <td>#{name}</td>
          </tr>
          <tr>
            <th>Superpowers:</th>
            <td>#{super_powers}</td>
          </tr>
          <tr>
            <th>History:</th>
            <td>#{bio}</td>
          </tr>
        </table>
        
        <div style="clear: both;"></div>
      </div>      
    }
  end

end