codifica

https://www.larry.dev/fix-character-encoding-website/

Hai problema di codifica da iso8859 a UTF8.
1. on 2021-01-04, ho fixato codifica ora goliardia e tuta UTF8. Ma non basta! 
    Ho ancora caratteri imputtaniti!
fixed UTF8 ora rendera correttamente.
  
2. char ancora imputtaniti

3. collation sfigata in MYSQL -> sembra si possa fixare con questa direttiva 

    set names ‘utf8’;
    che devi fare all inizio di ogni qiuery SQL :) 

o: 

    mysqli_set_charset ($link , ‘UTF8’ );
