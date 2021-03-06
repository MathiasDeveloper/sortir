module.exports = {
  purge: ["templates/**/*.twig"],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      fontFamily: {
        montserrat: ["Montserrat"],
      },
      maxWidth: {
        "8xl": "90rem",
      },
    },
  },
  variants: {
    extend: {},
  },
  plugins: [
    require("@tailwindcss/forms"),
    require("@tailwindcss/typography"),
    // require("@tailwindcss/aspect-ratio"),
    // require("@tailwindcss/line-clamp"),
  ],
};
