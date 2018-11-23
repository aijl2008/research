* namelookup_time: 解析时间， 从开始直到解析完远程请求的时间；
* connect_time: 建立连接时间,从开始直到与远程请求服务器建立连接的时间；
* pretransfer_time: 从开始直到第一个远程请求接收到第一个字节的时间；
* starttranster_time: 从开始直到第一个字节返回给curl的时间；
* total_time： 从开始直到结束的所有时间。

Pretransfer is when it wants to start sending, while starttransfer is when the first byte was actually sent (thus when the server was ready to receive something). 

Pretransfer 是当它想要开始发送时，而 starttransfer 是当第一个字节实际上被发送时(因此当服务器准备接收东西时)。