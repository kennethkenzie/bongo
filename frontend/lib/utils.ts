import { clsx, type ClassValue } from "clsx";
export function cn(...inputs: ClassValue[]) {
  return clsx(inputs);
}
export function formatPrice(n: number, currency = "USD") {
  return new Intl.NumberFormat("en-US", { style: "currency", currency, maximumFractionDigits: 2 }).format(n);
}
export function compactNumber(n: number) {
  if (n >= 1000) return (n / 1000).toFixed(n >= 10000 ? 0 : 1).replace(/\.0$/, "") + "K";
  return String(n);
}
