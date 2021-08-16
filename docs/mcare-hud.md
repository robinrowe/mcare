# MCARE HUD

by Robin Rowe 2021-07-04

## HUD Dock

The Dock is a horizontal task bar similar in function to that in MacOS. The dock auto-hides until hovered. The Dock is at typically at the top, not bottom of the screen. Which UI Controllers are active to manipulate the Dock depends upon player hardware capabilities, whether AR glasses, mobile or desktop. 

## UI Controllers

* Gaze, where the player is looking
* Gesture, where the player is pointing
* Speech IVR, a vocabulary of 32 commands
* Multi-modal, in which a app on a mobile phone makes it into a touchpad for use with AR headset
* Mobile, if there is only a phone and no headset
* Mouse, if there is any
* Chatbox, dot-commands are text-based chat messages that are system instructions

A dot-command is preceded with a period, e.g., ".camera" to activate the camera. A dot-command of ".verbose" will cause GUI events to echo to the chatbox. A dot-command of ".help" lists all dot-commands. Dot-commands may be shortened to the minimum number of characters that are unique, work like command-line tab-completion. Administrators and QA testers have superpower dot-commands, such as .mola=500, to give themselves 500 MOLA points.

### Icons

May possibly use BSD-licensed icons from http://svgicons.sourceforge.net/. The dock shows 7 icons:

* ?/Avatar (user's face): Login shows user's avatar, question mark otherwise 
* Camera: Cameras, Playback, VTC
* Checkmark: Checklists, Swipes, MRU
* Wrench: Tools such as Stopwatch, Calculator, Yardstick
* Gear: Settings
* Battery (indicator like on iPhone screen): Battery life indicator
* Score (a number): MoLA

### Potential Menu Items

1. Settings
1. Chat
1. VTC Call w/Remote Assist
1. Record/Playback
1. Checklist Playback/Author
1. Web Browser
1. Magnifier
1. Yardstick
1. Camera/Selfie
1. X-ray Vision
1. Waypoint/Track Target
1. Paging-to
1. Med Test (Blood pressure, X-ray, blood...)
1. MoLA Score
1. Stopwatch/Timer
1. Compass
1. Locate Object/Person (Defib, Fire Extinguisher)
1. Night Vision
1. Battery
