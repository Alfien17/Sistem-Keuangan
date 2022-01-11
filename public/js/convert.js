        $('#inputAngka').on('keyup',function(){
			var angka = $(this).val();

			var hasilAngka = formatRibuan(angka);

			/*$(this).val(hasilAngka);*/
			$('#showTextRibuan').text(hasilAngka);
		});

		function formatRibuan(angka){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			angka_hasil     = split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);



			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				angka_hasil += separator + ribuan.join('.');
			}

			angka_hasil = split[1] != undefined ? angka_hasil + ',' + split[1] : angka_hasil;
			return angka_hasil;
		}