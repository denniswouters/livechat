<html>
<body>
<link rel="stylesheet" href="style.css">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
<script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-app.js"></script>

<!-- Database connectie met Firebase -->
<script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-database.js"></script>

<script>
  // Configuratie met Firebase
  var firebaseConfig = {
    apiKey: "AIzaSyBNtwynwPSTvOtqPjmzi0_nJGTtZzFn_jI",
    authDomain: "live-chat-aca-it-solutions.firebaseapp.com",

    // Real time database URL
    databaseURL: "live-chat-aca-it-solutions-default-rtdb.europe-west1.firebasedatabase.app",

    projectId: "live-chat-aca-it-solutions",
    storageBucket: "live-chat-aca-it-solutions.appspot.com",
    messagingSenderId: "407969538909",
    appId: "1:407969538909:web:4d62f4b3b62d6d415fbeb4"
  };

  // Firebase initialiseren
  firebase.initializeApp(firebaseConfig);

  var myName = prompt("Wat is je naam?");

  function sendMessage() {
      // Bericht binnenkrijgen
      var message = document.getElementById("message").value;
      // Opslaan in de database
      firebase.database().ref("messages").push().set({
          "sender": myName,
          "message": message
      });
      // Voorkomen dat het bericht verzendt
      return false;
  }

    // Scannen/'luisteren' naar berichten die binnenkomen
    firebase.database().ref("messages").on("child_added", function (snapshot) {
      var html = "";
      // Ieder bericht een uniek ID meegeven
      html += "<li id='message-" + snapshot.key + "'>";

      // Delete knop
      if (snapshot.val().sender == myName) {
        html += "<button data-id='" + snapshot.key + "' onclick='deleteMessage(this);'>";
          html += "✖";
        html += "</button>";
      }
        html += snapshot.val().sender + ": " + snapshot.val().message;
      html += "</li>";
      document.getElementById("messages").innerHTML += html;
    });

    function deleteMessage(self) {

      // Message ID
      var messageId = self.getAttribute("data-id");

      // Bericht verwijderen
      firebase.database().ref("messages").child(messageId).remove();
    }

    // Listener toevoegen om bericht te verwijderen
    firebase.database().ref("messages").on("child_removed", function (snapshot) {

      // Tekst wanneer bericht verwijderd is.
      document.getElementById("message-" + snapshot.key).innerHTML = "Dit bericht is verwijderd.";
    });
</script>

<!-- Berichtenlijst -->
<div id = "Livechat">
  <div class="topframe">
    <img class="foto-medewerker" img src="/img/rw.jpg">
    <div class="online"></div>
    <p>Live chat ACA IT-Solutions</p>
  </div>
  <div id = "chatframe">
    <ul>
      <div class="intromessage"><span class="zwaai">👋</span>Hi! Stel ons je vraag...</div>
      <div id="messages"></div>
    </ul>
  </div>
  <div class="bottomframe">
    <form onsubmit="return sendMessage();">
        <input id="message" placeholder="Uw bericht" autocomplete="off">
        <input type="submit" value="➤">
    </form>
  </div>
</div>
</html>
</body>
