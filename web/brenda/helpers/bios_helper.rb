module BiosHelper
  def all_bios
    [general_bio, blues_bio, salsa_bio, wcs_bio, partner_bio_link].join("\n\n") + "\n\n"
  end
  
  def partner_bios
    [brendans_bio].join("\n\n")
  end
  
  def blues_bio
    bio "Blues Bio",
"Brenda is fulfilling her childhood dream as a professional dancer and instructor. She studies African American street dances from the turn of the century to the present.  Brenda travels around the world teaching and training with various coaches and historians. Her strength is breaking down the dances in a way that is accessible for anyone, even if they don't have a dance background.  She strives to help her students find the dancer with-in themselves, taking inspiration from dancers of the past.  Brenda is working with the Blues dance community during this time of growth to develop curriculum and events that raise the community's level of dancing.  Her hope is to provide structure for duplicable material, while keeping the inherent character and nature of the dance."
  end
  
  def general_bio
    bio "General Bio",
"Brenda is fulfilling her childhood dream as a professional dancer and instructor.  Brenda's early dance training included about 30 dance styles.  She has also studied musical history and theory, dance history, dance instruction, several physical health methods, and other related subjects adding to her knowledge of the body, dance, music, and teaching.  Brenda continues to study and train with coaches, historians, and practitioners, always striving to increase her understanding and ability.

Brenda has put the majority of her focus over the past many years into the Lindy Hop, Balboa, Blues, West Coast Swing, and Salsa communities.  She believes we are all born with dance in our bodies, and that each of us can use this activity as a means for personal expression, connecting with others, and exercise.   Brenda loves the image of being able to dance anytime, anywhere, to any music, alone, or with anyone.  She spends her time living this dream for herself while assisting her students in accomplishing their personal dance goals."
  end
  
  def wcs_bio
    bio "West Coast Swing Bio",
"Brenda first encountered West Coast Swing when she attended Saturday Night Fever in 2000, which was advertised as a Hustle dance, but turned out to be primarily WCS.  She took some classes and attended occasional dances in Portland and Corvalis, but really fell in love with the dance when the Viscount opened up a WCS room upstairs on Tuesday nights. Being able to dance WCS weekly in a casual environment lit her passion for this dance.

Brenda entered her first WCS J&J at Monster Mash 2002 in Spokane while she was there on staff as a Lindy Pro.  While she enjoys competing and performing from time to time, teaching has been Brenda's main focus and has led her to search out the most experienced and knowledgeable coaches she can find.  She has studied under Barry Douglas, May Ann Nuniez, Sylvia Sykes, Arjay Centeno, as well as many other renowned instructors.

Brenda started teaching WCS in 2004 and has been organizing the Wednesday West Coast Swing dance in Portland along with Hugo Chang since the Viscount closed it's doors in 2005.

Brenda continues to travel studying West Coast Swing along with many other Swing and Latin dances, always striving to bring the latest techniques and trends back to Portland."
  end

  def salsa_bio
    bio "Salsa Bio",
"Brenda has always been drawn to Latin music from early childhood, listening to Julio Eglasias, Los Lobos, Gloria Estefan...anything remotely latin stood out to her.  When she began seriously partner dancing in 2000 Salsa and other Latin club dances became part of her regular routine.  The freedom of movement, inherent rhythms, and call response between partners has made Salsa one Brenda's favorite dance forms.  She studied with Duplessey-Monic Walker, Barry Douglas, and many other renowned instructors from the West and East coasts.  Brenda also privately studied Latin drumming and music with Derek Reith to better understand the music and rhythms and how the dance was connected to them.  Brenda studied every type of African based dance she could find.  After many years of studying movement, music, and partnering Brenda applies her collective knowlege of African based dance to her break down of Salsa, Cha Cha Cha, Mambo, Cumbia, Bachata, and more.
"
  end
  
  def brendans_bio
    bio "Brendan Woodrow's Bio",
"Brendan Woodrow started dancing West Coast Swing in 2007 after hearing about it from a ballroom instructor. He immediately fell in love with the dance's smooth style and subtle movements and decided that this was a dance he should learn more about. Brendan started immersing himself in as much WCS training as he could find in Portland. He took classes from Chris Jones, Trina Siebert, and Jason Isbell as well as received private training from Brenda Collins, Glenna Cooke, and Jenica Krolicki. Currently, Brendan receives most of his training from dance coach Barry Douglas.

Since May, 2008, Brendan has been traveling the world with Brenda Collins assisting her in teaching, and training as a full time dancer. This constant immersion has accelerated his absorption of dance knowledge exponentially. He believes that his additional study in other swing dances, such as Balboa, Lindy Hop, and Blues, has greatly influenced his personal style and expanded his understanding of dance movement and physics.

When it comes to teaching, Brendan has a strong focus on foundational movement and solid dance basics. His primary goal is to take the training he is gathering as he travels and bring it back to students at home. Whether it's a tip he picked up from Lindy Hoppers in Sweden, Balboa dancers in London, or from a West Coast Swing pro in California; Brendan enjoys passing on as much of that information as possible to all of his dancing friends."
  end
  
  def partner_bio_link
    "<div class='bio'>#{link_to "<b>Partner Bios</b>", "partner_bios.html"}...</div>"
  end
  
  def bio(name, copy)
    "<div class='bio'>
<h3>#{name}</h3>
<div class='excerpt'>

#{excerpt(copy)} #{link_to_function "read more", "$(this).parent().parent().parent().addClass('full_text')"}

</div>
<div class='full_text'>

#{copy}

</div>
</div>

"
  end
  
  def excerpt(copy)
    copy.split(" ")[0..20].join(" ") + "..."
  end
end