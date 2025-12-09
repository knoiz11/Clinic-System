new Def.Autocompleter.Search('icd11_codes', 'https://clinicaltables.nlm.nih.gov/api/icd11_codes/v3/search?sf=code,title',
 {tableFormat: true, valueCols: [0], colHeaders: ['Code', 'Title', 'Type']});