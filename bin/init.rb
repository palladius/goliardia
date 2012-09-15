#!/usr/bin/env ruby


	# dovrei accertarmi di essere in un BASE contenente immagini uploadz etc...
def init_goliardia(dir)
	`cd ${dir}`
	# cose cambiabili da palo:
	%w[ citta ordini persone ].each { |d| 
			puts "+ Rendo cambiabile da Palo la directory img-#{d}..."
			`chown www-data.www-data ./immagini/#{d}`
			`chmod 775 ./immagini/#{d}` 
			puts '... e il suo contenuto (muto):'
			`chown www-data.www-data ./immagini/#{d}/* 2>/dev/null`
			`chmod 664 ./immagini/#{d}/* 2>/dev/null `
	}
	puts "Var scrivibili da apache (per darla via devi essere ROOT, mica come le donne):"
	%w[ var/log var/state var/prova uploads/thumb ].each{ |dtutti|
		`mkdir -p #{dtutti}` # create if doesnt exist
		`chown www-data.www-data #{dtutti}`  # devi essere root
		`chmod 775 #{dtutti}`
	}

end

init_goliardia '/var/www/www.goliardia.it/'
