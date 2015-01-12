exports.run = function() {

  return {
      uri:'\\/supplements$',
      selectors:{
          addSupplementButton:'.index-table-tools .button:first-of-type',
          saveButton:'.button[value="Save"]',
          firstSupplement:'.index-table-cell:first-of-type a'
      }
  };

};