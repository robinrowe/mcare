mysql database dump creates all the tables and inserts data on them. Databse name should be "who"
Web folder has the php files to add, edit and delete hospitals
mapper folder has the backoffice to create the map (start.php for geometry, addprop.php to create props, addfloor.php to create drawings on the floor, path.php to create paths on the floor)
mapper/preview folder has preview.php to visualize in 3d using a-frame everything created using the other mentioned pages)
mapper/preview/textures as all the materials for the 3d assets.
There is only one connection to the database shared by all pages on web/db.php

