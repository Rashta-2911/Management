module.exports = function stripSourceMedia() {
  return {
    postcssPlugin: 'strip-source-media',
    Once(root) {
      root.walkAtRules('media', (rule) => {
        if (rule.params === 'source(none)') {
          rule.replaceWith(rule.nodes);
        }
      });
    },
  };
};
module.exports.postcss = true;
