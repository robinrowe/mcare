# Packet Format

* 24-byte packet header
* ASIIZ: Payload

If a payload takes multiple fields, they are separated by pipes, that is, '|'. 

## Packet Header

* 32-bit checksum
* 16-bit short: TotalPacketLength
* 16-bit short: PacketID (increases monatomically, wraps around)
* 32-bit int: FromId (server = 0)
* 32-bit int: ToId (user = 1)
* 32-bit int: Time since game start in hundredths of seconds
* 4-byte command: e.g., "MOVE", not null terminated

Bits are in Network Order. Little Endian platforms must do bit-shifting.

## Example Move Packet

Move packet contents: # 36 1 0 1 10.00 MOVE 100,100,20|\0. 

Above packet is 36 bytes long (24 + 11 + 1). Server says MOVE user #1 to xyz position 100,100,20.

## Packet Types

* ADDD: Add Decision
* ADDE: Add Equipment
* ADDL: Add MoLA
* ADDM: Add meds to inventory
* ADDP: Add Player
* ADDQ: Add Question
* ADDS: Add Sound or media
* AVAT: Avatar
* CHAT: Chat message
* DEAD: Dead patient, has died 
* DECI: Decision
* DRUG: Query drug in inventory
* ENDG: End Game
* GAME: START|STOP|INFO, what a player may join
* HOSP: Hospital to load
* ITEM: Furniture or medical equipment
* JOIN: Join game or team
* LEAV: Leave game or team
* LOAD: Game list, per Country #, or zero to get list of closest games
* LOCA: Location
* LOGI: Login
* LOGO: Logout
* MOVE: Move item or player
* PAGE: Page with PA or beeper
* PATI: Patient action
* PERS: Add or drop personel NPC
* PIPW: PiP Window
* PLAY: Sound or media file
* QUES: Question
* REPL: Replay
* ROOM: Add or drop a room
* STAR: Start game
* STAT: Stats
* STOP: Stop game by pausing
* SURG: Surgical procedure
* TEAM: Team info
* TIME: Time
* TRIA: Triage
* VITA: Vitals of patient
