import { clsx, type ClassValue } from "clsx";
import type { Currency } from "./types";
export function cn(...inputs: ClassValue[]) {
  return clsx(inputs);
}
export function formatPrice(n: number, currency: string | Currency = "USD") {
  const code = typeof currency === "string" ? currency : currency.code;
  const rate = typeof currency === "string" ? 1 : Number(currency.exchange_rate ?? 1);
  const value = n * (Number.isFinite(rate) ? rate : 1);

  try {
    return new Intl.NumberFormat("en-US", { style: "currency", currency: code, maximumFractionDigits: 2 }).format(value);
  } catch {
    const symbol = typeof currency === "string" ? code : (currency.symbol || code);
    return `${symbol} ${value.toLocaleString("en-US", { maximumFractionDigits: 2 })}`;
  }
}
export function compactNumber(n: number) {
  if (n >= 1000) return (n / 1000).toFixed(n >= 10000 ? 0 : 1).replace(/\.0$/, "") + "K";
  return String(n);
}
