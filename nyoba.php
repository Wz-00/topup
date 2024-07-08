<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Card</title>
    <style>
        .card {
            border: 1px solid #000;
            padding: 20px;
            margin: 10px 0;
            position: relative;
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="container">
        <div class="card">
            <button class="close-btn" onclick="hapusCard(this)">x</button>
            <h3>Card 1</h3>
            <label for="input1">Input 1:</label>
            <input type="text" id="input1" name="input1">
            <br>
            <label for="input2">Input 2:</label>
            <input type="text" id="input2" name="input2">
            <br>
            <label for="input3">Input 3:</label>
            <input type="text" id="input3" name="input3">
        </div>
    </div>
    <button id="tambah">Tambah</button>

    <script>
        document.getElementById('tambah').addEventListener('click', function() {
            // Ambil elemen container
            var container = document.getElementById('container');
            
            // Ambil elemen card terakhir
            var lastCard = container.querySelector('.card:last-of-type');
            
            // Clone elemen card terakhir
            var newCard = lastCard.cloneNode(true);
            
            // Update heading card yang baru
            var cardCount = container.getElementsByClassName('card').length + 1;
            newCard.querySelector('h3').textContent = 'Card ' + cardCount;
            
            // Reset input fields
            var inputs = newCard.getElementsByTagName('input');
            for (var i = 0; i < inputs.length; i++) {
                inputs[i].value = '';
            }
            
            // Append card baru ke container
            container.appendChild(newCard);

            // Update visibility of close buttons
            updateCloseButtons();
        });

        function hapusCard(button) {
            // Hapus card
            var card = button.parentNode;
            card.parentNode.removeChild(card);

            // Update visibility of close buttons
            updateCloseButtons();
        }

        function updateCloseButtons() {
            var cards = document.getElementsByClassName('card');
            if (cards.length === 1) {
                cards[0].querySelector('.close-btn').style.display = 'none';
            } else {
                for (var i = 0; i < cards.length; i++) {
                    cards[i].querySelector('.close-btn').style.display = 'block';
                }
            }
        }

        // Initial call to hide the close button if there's only one card
        updateCloseButtons();
    </script>
</body>
</html>
