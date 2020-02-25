const express = require('express')
const app = express()
app.use(express.json());
const request = require("request-promise");
process.env["NODE_TLS_REJECT_UNAUTHORIZED"] = 0;
app.get('/', (req, res) => {
  res.send('Hello World')
  console.log("get",req.params);
})

app.post('/webhook', (req, res) => {
  // res.send('Hello World')
  // console.log("post",req.body);
  let req_json = req.body;
  console.log(req_json.events[0].message)
  let msg_type = req_json.events[0].message.type;
  if(msg_type === "text"){
    request.post({
      uri: "https://bots.dialogflow.com/line/3f782dfd-3876-483a-a09d-3b17a3adcb04/webhook",
      headers: req.headers,
      body: JSON.stringify(req.body)
    });
  }else{
     // console.log(JSON.stringify(req.body))
     // return
      request.post({
      uri: "http://localhost:80/Login_v4/fulfilment.php",
      headers: req.headers,
      body: JSON.stringify(req.body)
    },
    function callback(err, httpResponse, body) {
      if (err) {
        return console.error('Call failed:', err);
      }
      console.log('Call successful!  Server responded with:', httpResponse.body);
    }
  );
  }

})

app.listen(3000, () => {
  console.log('Start server at port 3000.')
})
