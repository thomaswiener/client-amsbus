## API AMS

### 1.1 GET MaskSearch
```php
URL: v1/MaskSearch/{guid}?mask={mask}
HTTP operation: GET
```

#### Request

Parameter          | type       | description
-------------------|------------|-------------
{guid}             | string     | ID partner (static, received from the service admin)
{mask}             | string     | name mask of searched objects

#### Response

Parameter          | type       | description
-------------------|------------|-------------
result of function | string[]   | name list of searched objects

Description: Function enumerates the list of objects (destinations and stations) complies with the entered mask. Function returns maximally 30 objects.

### 1.2 GET Connection
URL: v1/Connection/{guid}?from={from}&to={to}&dateTime={dateTime}&searchFlags={searchFlags}
HTTP operation: GET, POST
Parameter	type	description
{guid}	string	ID partner (static, received from the service admin)
{from}	string	name or mask of object FROM (starting point of connection)
{to}	string	name of mask of object TO (finishing point of connection)
{dateTime}	DateTime	date and time of ride (if it’s not entered, actual date is used)
{searchFlags}	int	signs for searching according enum SEARCHFLAGS (if it’s not entered, nothing)
result of function	ConnectionArray	searched connections
Description:
Function solves the entered masks of objects and if successful, searches connection. As connections here, are considered only direct connections; connections with stopovers can’t be searched. Function returns maximally 10 connections. Basic details (connection handle, connection index, from, to, dates and times, standard price, line number and operator, number of free seats) are returned to each connection. By using parameter {searchFlags} can be requirements on the connection (i.e. search only connections, that don’t require printed e-ticket); entering these requirements is usually pointless because they follow from operator’s characteristics.

### 1.3 GET ConnectionBack
URL: v1/ConnectionBack/{guid}/{handleThere}/{idxThere}?from={from}&to={to}&dateTime={dateTime}&
searchFlags={searchFlags}
HTTP operation: GET, POST
Parameter	type	description
{guid}	string	ID partner (static, received from the service admin)
{handleThere}	int	handle connection there
{idxThere}	int	index connection there
{from}	string	name or mask of object FROM (starting point of connection)
{to}	string	name of mask of object TO (finishing point of connection)
{dateTime}	DateTime	date and time of ride (if it’s not entered, actual date is used)
{searchFlags}	int	signs for searching according enum SEARCHFLAGS (if it’s not entered, nothing)
function result	ConnectionArray	searched connections
Description:
Function searches return connections – means those connections that are suitable for connection there (TO). Entered leaving time {dateTime}  can’t be earlier than time of connection there (TO destination).

### 1.4 GET ConnectionInfo
URL: v1/ConnectionInfo/{guid}/{handle}/{idx}
HTTP operation: GET
Parameter	type	description
{guid}	string	ID partner (static, received from the service admin)
{handle}	int	handle connection
{idx}	int	index connection
result of function	ConnectionInfo	connection details
Description:
Function returns detail information about one concrete connection, means list of tariffs, prices and operators on that connection including seat map of bus, else information that reservation is not working with particular seats.

### 1.5 POST SeatBlock
URL: v1/SeatBlock/{guid}/{handle}/{idx}
HTTP operation: POST
Parameter	type	description
{guid}	string	ID partner (static, received from the service admin)
{handle}	int	handle connection
{idx}	int	index connection
request body	SeatRequest	required tariff (rate) and seats
result of function	BlockInfo	information about booked seats and prices
Description:
Function executes blocking seats and determines prices, which is the first step towards purchasing the tickets. If {handle} connection BACK, then both ways ticket is booked. Blocking of seats is valid for 15 minutes; if in this time the booking is not finished by user (by operation POST Ticket), blocking is over/fails.
Result of function (object type BlockInfo) contains handle of assigned seats, which are used in following operations and basic information about ticket being created (seat numbers there and back, price, list of required additional user information – i.e. name, ID/passport number, phone).

### 1.6 DELETE SeatBlock
URL: v1/SeatBlock/{guid}/{ticketHandle}
HTTP operation: DELETE
Parameter	type	description
{guid}	string	ID partner (static, received from the service admin)
{ticketHandle}	string	handle assigned seats (from result of operation POST SeatBlock)
Description:
Function releases seats blocked operation POST SeatBlock. Client should use this function in case he reserves seats and then decides not to finish the booking.

### 1.7 POST Ticket
URL: v1/Ticket/{guid}/{ticketHandle}
HTTP operation: POST
Parameter	type	description
{guid}	string	ID partner (static, received from the service admin)
{ticketHandle}	string	handle assigned seats (from result of operation POST SeatBlock)
body of request	AdditionalInfo[]	additional information about travellers
result of function	Ticket[]	information about created tickets
Description:
Finishing of ticket purchase and entering additional user details.
If connection handle BACK was entered in BlockSeat function, purchase of both ways ticket is finished. Only the additional details which were requested for that particular connection, must be entered.
Information about created tickets (as result of function) contains mainly URL, where PDF ticket can be downloaded. Furthermore transaction code and price of course too.

### 1.8 GET Ticket
URL: v1/Ticket/{guid}/{ticketHandle}
HTTP operation: GET
Parameter	type	description
{guid}	string	ID partner (static, received from the service admin)
{ticketHandle}	string	handle assigned seats (from result of operation POST SeatBlock)
result of function	Ticket[]	information about created tickets
Description:
Function allows getting data about sold tickets after purchase (means after POST Ticket operation) (the same answer that POST Ticket returns – i.e. when partner doesn’t get any answer on POST Ticket query). This function is available until 15 minutes after purchase only.
In case operation POST Ticket wasn’t finished (or 15 minutes after execution was expired) function returns HTTP status 404 – NotFound.

### 1.9 DELETE Ticket
URL: v1/Ticket/{guid}/{ticketHandle}
HTTP operation: DELETE
Parameter	type	description
{guid}	string	ID partner (static, received from the service admin)
{ticketHandle}	string	handle assigned seats (from result of operation POST SeatBlock)
result of function	Ticket[]	information about created tickets
Description:
Function allows cancelling purchase (means successful operation POST Ticket) without cancellation fee. It is determined for solution of technical problems (i.e. in case the ticket wasn’t able to get downloaded or printed) and its usage can be done within 15 minutes after purchase only.
In case operation POST Ticket wasn’t finished (or 15 minutes after execution was expired) function returns HTTP status 404 – NotFound.

### 1.10 POST Refund1
URL: v1/Refund1/{guid}/{transCode}/{operation}
HTTP operation: POST
Parameter	type	description
{guid}	string	ID partner (static, received from the service admin)
{transCode}	string	6-digit transactional code of refunded
{operation}	int	required operation, means status, which direction of ticket should be refunded (there, back or both); if it isn’t entered, direction there will be refunded
result of function	RefundInfo	information about refund
Description:
Functions starts refund operation of ticket – means it is blocking ticket and calculates price for refund. Subsequently, client has to decide in 15 minutes if he finishes the refund (by operation POST Refund2) or refuses (by operation DELETE Refund1) – in this case ticket remains valid. In case client doesn’t make any of these operations in 15 minutes, operation is cancelled and ticket remains valid.
In the final structure (RefundInfo), only some data are filled (especially refund amount, handle of operation in progress).

### 1.11 DELETE Refund1
URL: v1/Refund1/{guid}/{refundHandle}
HTTP operation: DELETE
Parameter	type	description
{guid}	string	ID partner (static, received from the service admin)
{refundHandle}	string	handle of working returning operation (from result of POST Refund1)
Description:
Function cuts off refund operation (in progress by POST Refund1). User should use this function if he started refund operation and decides not to finish it. Ticket remains valid.
This function can be executed in 15 minutes after POST Refund1 only.

### 1.12 POST Refund2
URL: v1/Refund2/{guid}/{refundHandle}
HTTP operation: POST
Parameter	type	description
{guid}	string	ID partner (static, received from the service admin)
{refundHandle}	string	handle of working returning operation (from result of POST Refund1)
result of function	RefundInfo	information about refund
Description:
Function finishes refund operation – means really makes the ticket invalid and releases that blocked seats. If it was refund of only one direction, there is information about the new (remaining) ticket in the result (RefundInfo).
This function can be executed in 15 minutes after POST Refund1 only.
