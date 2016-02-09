BB10-ExternPromoManager-QML
===================

Made by Jacopo Federici
jacopofederici@ymail.com

folder content:
- promo.php: php file to upload on the server
- promo.txt: 	txt file to upload on the server in the same folder of promo.php. it contains the list of promotions
- PromoManager.qml: the qml ActionItem to attach in your App
		
**Example:**

in your setting page or wherever you want allow the user to check the promotion

    actions: [
		ActionItem {
			title: qsTr("Restore Setting")
			/* ... */
		},
		ActionItem {
			title: qsTr("Restore Purchase")
			/* ... */
		},
		PromoManager {
			id: promoManager
			title: "PROMO CODE"
			imageSource: "asset:///images/ic_favorite.png"
			ActionBar.placement: ActionBarPlacement.OnBar
			//IMPORTANT
			serverURL: "<your server url + path of files 1 and 2>promo.php?code="
			onCodeObtained: {
				if (code == 1) {
					//here your code to save the PRO status
					//for me this:
						//AppMethod.saveSetting("setting/proversion", 1);
					console.log("proversion = true");
				}
			}
		}
	]


the sequence is:

	- **promoManager triggering**
	- **sysp_promocode will be showed to insert the promo code**
	- **on sysp_promocode onFinished**
		- spdVerificaPromoCode.checkPromoCode() will be called (XMLHttpRequest() asinc)
		- spdVerificaPromoCode will be showed. it displays the state of the request
	- **on request finished**
- codeObtained will be emitted with the code obtained from the XMLHttpRequest
		- sysp_promocode_Toast will be showed with the correct text body
- **catch the signal to save the PRO state in your app.**


example:

  	onCodeObtained: {
		if (code == 1) {
			console.log("proversion = true");
			//here your code to save the PRO status
		}
	}


---------
