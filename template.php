<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset=utf-8 />
	<title>Printing Paper</title>
	<meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
	<link rel="stylesheet" type="text/css" href="./css//paper.css">
	<script type="text/javascript" src="./js/jquery.min.js"></script>
	<script type="text/javascript" src="./js/JsBarcode.min.js"></script>
	<script type="text/javascript" src="./js/qrcode.min.js"></script>
	<style media="print">
		@page {
			margin: 0;
		}
	</style>
</head>
<body>
	<div id="paper_container" class="paper_container">
		<div class="paper_header">
			<span class="title"></span>
		</div>
		<div id="paper_wrapper" class="paper_wrapper">
		</div>
		<div class="paper_footer">
			<span class="title"></span>
		</div>
	</div>
	<script type="text/javascript">
		var datas = <?php echo $_POST['item_data']; ?>
		
		$(document).ready(function() {
			console.log("datas", datas);
			updateComponents();
			window.focus();
			window.print();
			window.close();
		})
		function updateComponents() {
			var size = datas.size;
			$("#paper_container").css({"width": size.nWidth, "height": size.nHeight});
			var header = datas.header;
			var footer = datas.footer;
			var barcode1 = datas.barcode1;
			var barcode2 = datas.barcode2;
			var data = datas.data;
			$(".paper_header .title").html(header);
			$(".paper_footer .title").html(footer);
			var n = data.length;
			for (var i = 0; i < n; i++) {
				var oFont = data[i].oFont;
				var nRow = data[i].nRow;
				var nColumn = data[i].nColumn;
				var cData = data[i].cData;

				var style = "position: absolute; top: "+nRow+"%; left: "+nColumn+"%; font: "+oFont+";";
				var field_html = "<div class='added-item text-div' style='"+style+"'>"+cData+"</div>";
				$(".paper_wrapper").append(field_html);
			}
			var m = barcode1.length;
			for (var i = 0; i < m; i++) {
				var nRow = barcode1[i].nRow;
				var nColumn = barcode1[i].nColumn;
				var nWidth = barcode1[i].nWidth;
				var nHeight = barcode1[i].nHeight;
				var cData = barcode1[i].cData;
				var id = "item_barcode1_"+i;
				var style = "position: absolute; top: "+nRow+"%; left: "+nColumn+"%;";
				var svgStyle = "width: "+nWidth+"px; height: "+ nHeight+"px;";
				var field_html = '<div style="'+style+'" class="added-item barcode1"><svg id="'+id+'" style="'+svgStyle+'"></svg></div>';
				$(".paper_wrapper").append(field_html);
				JsBarcode("#"+id, cData);
				$("#"+id).css({ transform: 'rotate(-90deg)' });
			}
			var k = barcode2.length;
			for (var i = 0; i < k; i++) {
				var nRow = barcode2[i].nRow;
				var nColumn = barcode2[i].nColumn;
				var nSize = barcode2[i].nSize;
				var cData = barcode2[i].cData;
				var id = "item_barcode2_"+i;
				var style = "position: absolute; top: "+nRow+"%; left: "+nColumn+"%;";
				var field_html = '<div style="'+style+'" class="added-item barcode2" data="'+cData+'"><div id="'+id+'"></div></div>';
				$(".paper_wrapper").append(field_html);

				var qrcode = new QRCode(id, {
				    text: cData,
				    width: nSize,
				    height: nSize,
				    colorDark : "#000000",
				    colorLight : "#ffffff",
				    correctLevel : QRCode.CorrectLevel.H
				});
			}
		}
	</script>
</body>
</html>