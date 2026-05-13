import type { Config } from "tailwindcss";

const config: Config = {
  content: [
    "./app/**/*.{js,ts,jsx,tsx,mdx}",
    "./components/**/*.{js,ts,jsx,tsx,mdx}",
    "./lib/**/*.{js,ts,jsx,tsx,mdx}"
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          50: "#f5edff",
          100: "#e9d8ff",
          200: "#d4b1ff",
          300: "#bd86ff",
          400: "#a25cff",
          500: "#8a3df3",
          600: "#7c2ae8",
          700: "#6a1fcc",
          800: "#561aa6",
          900: "#3f1280"
        },
        ink: {
          DEFAULT: "#222222",
          soft: "#4b4b4b",
          muted: "#757575"
        },
        line: "#e5e5e5",
        surface: "#f5f5f5",
        deal: "#ff3b30",
        savings: "#ff6a00"
      },
      borderRadius: {
        sm: "2px",
        DEFAULT: "3px",
        md: "4px",
        lg: "4px",
        xl: "4px"
      },
      fontFamily: {
        sans: ["Inter", "system-ui", "-apple-system", "Segoe UI", "Roboto", "sans-serif"]
      },
      boxShadow: {
        card: "0 1px 2px rgba(0,0,0,0.04), 0 1px 3px rgba(0,0,0,0.06)",
        pop: "0 6px 24px rgba(0,0,0,0.10)"
      }
    }
  },
  plugins: []
};

export default config;
