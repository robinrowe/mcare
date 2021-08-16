# MCARE Spatial Audio

by Robin Rowe 2020/6/28

_What is our thinking in relation to audio in the game, in terms of how the procedural and spatial aspects will be handled?_

The fundamental concept is every sound has a location in 3D space. 

## Dolby Atmos

Dolby Atmos seems to be the state of the art today:

* [Dolby Developer](https://developer.dolby.com/platforms/html5/overview/)

* [Dolby Atmos in Games](https://www.pocket-lint.com/games/news/dolby/141761-dolby-atmos-for-gaming-what-is-it-and-what-games-support-it)

## Spatial Audio Research

The original research in gaming spatial audio was done at NPSNET, when I was on the dev team there in the mid-1990s. Might find something useful there on spatial audio theory:

* [Headphone-delivered three dimensional sound in NPSNET](https://calhoun.nps.edu/handle/10945/32217)
* [NPSNET: aural cues for virtual world immersion](https://calhoun.nps.edu/handle/10945/23731)
* [Free field spatialized aural cues for synthetic environments](https://calhoun.nps.edu/handle/10945/43018)

## Hello World

A first step is to create a 'Hello World' spatial audio app, with a point-source sound that a user can walk around and sense the sound is staying put as the user moves. As a temp track we can record, "Paging Doctor Olim. Dr. Olim to Triage stat." Play that in a loop with ourselves as an NPC avatar in the room. The room having 4 walls and in the middle of the room there's a speaker (a box, not a person). We as the avatar travling in an orbit around the speaker.

While our target platform is WebAudio, a UWP implementation would be nice to have as well, to hear if it sounds identical.

Hello World is only a simple test app. Once we have that done, we can create a separate app that has a hospital reception room and an operating theater room.

## Hello World Test Server

A simple, manually operated, test server that for UI has a web cgi form. Create a plain web form using http://www.phpform.org/ or whatever. Form will interface with a websocket server we build. Maybe Apache cgi-bin or node.js or ???

Web form has a FromId field (int), a ToId field (int), a 2-letter command code field, a text payload field and a Submit button. Data collected from form is sent down a websocket on port 8080 to the HelloWorld app. 

## Packet Format

* 12-byte packet header
* 2-byte command: XX
* ASIIZ: Payload

If a payload takes multiple fields, they are separated by pipes, that is, '|'. 

### Packet Header

* 16-bit short: TotalPacketLength
* 16-bit short: PacketID (increases monatomically, wraps around)
* 32-bit int: FromId (server = 0)
* 32-bit int: ToId (user = 1)

Bits are in Network Order. Little Endian platforms must do bit-shifting.

### Example Move Packet

Move packet contents: 25 0 0 1 MV 100,100,20\0. 

Above packet is 25 bytes long (12 + 2 + 11). Ignoring PacketID for now, server says MoVe user #1 to xyz position 100,100,20.

### Links

[3D Audio Basics[(https://youtu.be/K9wlZveOw_M)
[Ambisonics 3D audio in Pro Tools](https://youtu.be/p7olXJuE9_w)
[Apple Spatial Audio](https://www.makeuseof.com/what-is-spatial-audio/)
[3D audio on headphones](https://www.waves.com/nx)
[with optional head-tracker](https://www.waves.com/hardware/nx-head-tracker)
[Room EQ](https://www.roomeqwizard.com/)
